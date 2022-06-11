<?php

namespace Drupal\islandora_csl\Encoder;

use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\node\Entity\Node;;

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
  public function supportsEncoding($format) {
    return $format === self::$format;
  }


  /**
   * {@inheritdoc}
   */
  public function encode($data, $format = '', array $context = []) {
    $result = [];
    foreach ($data as $field => $values) {
      if (empty($values)) continue;
      switch ($field) {
        case 'title':
          $result['title'] = strip_tags($values[0]['value']);
          break;
        case 'field_linked_agent':
          foreach ($values as $value) {
            $author = Term::load($value['target_id']);
            if ($author) {
              if ($author->vid->value == 'person') {
                // assummes format GIVEN [MIDDLE] FAMILY
                // TODO: improve
                $components = explode(" ", $author->label());
                $family = array_pop($components);
                $given = implode(" ", $components);
                $result['author'][] = [
                  'given' => $given,
                  'family' => $family,
                ];
              }
              else {
                $result['author'][] = [
                  'family' => $author->label(),
                ];
              }
            }
          }
          break;
        case 'field_publication':
          $term = Term::load($values[0]['target_id']);
          if ($term) $result['publisher'] = $term->label();
          break;
        case 'field_edtf_date_issued':
        case 'field_edtf_date':
          $value = strip_tags($values[0]['value']);
          $result['issued']['date-parts'][] = explode('-', $value);
          break;
        case 'nid':
          $nid = $values[0]['value'];
          $node = Node::load($nid);
          if ($node) {
            $result['id'] = $nid;
            $result['URL'] = $node->toUrl('canonical', ['absolute' => TRUE])->toString();
          }
          break;
      }
    }

    return json_encode($result);
  }
}
