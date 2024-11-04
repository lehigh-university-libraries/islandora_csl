<?php

namespace Drupal\islandora_csl\Encoder;

use Drupal\controlled_access_terms\EDTFUtils;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * CSL format encoder.
 */
class CslEncoder implements EncoderInterface {

  /**
   * The format that this encoder supports.
   *
   * @var array
   */
  protected static $format = 'csl';

  /**
   * {@inheritdoc}
   */
  public function supportsEncoding(string $format) : bool {
    return $format === self::$format;
  }

  /**
   * {@inheritdoc}
   */
  public function encode(mixed $data, string $format = '', array $context = []) : string {
    $result = ['type' => 'journal-article'];
    $entityTypeManager = \Drupal::service('entity_type.manager');
    $nodeStorage = $entityTypeManager->getStorage('node');
    $termStorage = $entityTypeManager->getStorage('taxonomy_term');
    foreach ($data as $field => $values) {
      if (empty($values)) {
        continue;
      }
      switch ($field) {
        case 'field_full_title':
          $result['title'] = $values[0]['value'];
          break;

        case 'field_linked_agent':
          foreach ($values as $value) {
            if (empty($value['rel_type'])) {
              continue;
            }
            if (!in_array($value['rel_type'], ['relators:cre', 'relators:aut'])) {
              continue;
            }
            $author = $termStorage->load($value['target_id']);
            if ($author) {
              $label = explode(' - ', $author->label());
              $label = $label[0];
              if ($author->bundle() == 'person') {
                if (strpos($author->label(), ",") === FALSE) {
                  $components = explode(" ", $label);
                  $family = array_pop($components);
                  $given = implode(" ", $components);
                }
                else {
                  $components = explode(",", $label);
                  $family = array_shift($components);
                  $given = implode(" ", $components);
                }
                $result['author'][] = [
                  'given' => $given,
                  'family' => $family,
                ];
              }
              else {
                $result['author'][] = [
                  'family' => $label,
                ];
              }
            }
          }
          break;

        case 'field_publication':
          $term = $termStorage->load($values[0]['target_id']);
          if ($term) {
            $result['publisher'] = $term->label();
          }
          break;
        case 'field_identifier':
          foreach ($values as $value) {
            if (!empty($value['attr0']) && $value['attr0'] == 'doi') {
              $result['DOI'] = substr($value['value'], strpos($value['value'], '10.'));
              $result['DOI'] = substr($result['DOI'], 0, strpos($result['DOI'], '"'));
            }
          }
          break;
        case 'field_part_detail':
          foreach ($values as $value) {
            if (!empty($value['type']) && $value['type'] == 'volume') {
              $result['volume'] = $value['number'];
            }
            if (!empty($value['type']) && $value['type'] == 'issue') {
              $result['issue'] = $value['number'];
            }
          }
          break;
        case 'field_edtf_date_issued':
        case 'field_edtf_date':
          if (empty($values[0]['value'])) {
            break;
          }
          $value = EDTFUtils::iso8601Value($values[0]['value']);
          $value = explode('T', $value)[0];
          $result['issued']['date-parts'][] = explode('-', $value);
          break;

        case 'nid':
          $nid = $values[0]['value'];
          $node = $nodeStorage->load($nid);
          if ($node) {
            $result['id'] = $nid;

            $url = $node->toUrl('canonical', ['absolute' => TRUE])->toString();
            if ($format == '') {
              $result['URL'] = $url;
            }
            else {
              $result['URL'] = "<a href=\"$url\">$url</a>";
            }
          }
          break;
      }
    }

    return json_encode($result);
  }

}
