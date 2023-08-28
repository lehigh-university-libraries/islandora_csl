<?php

namespace Drupal\islandora_csl\Encoder;

use Symfony\Component\Serializer\Encoder\EncoderInterface;

if (floatval(\Drupal::VERSION) < 10.0) {
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
      $entityTypeManager = \Drupal::service('entity_type.manager');
      $nodeStorage = $entityTypeManager->getStorage('node');
      $termStorage = $entityTypeManager->getStorage('taxonomy_term');
      foreach ($data as $field => $values) {
        if (empty($values)) {
          continue;
        }
        switch ($field) {
          case 'title':
            $result['title'] = strip_tags($values[0]['value']);
            break;

          case 'field_linked_agent':
            foreach ($values as $value) {
              $author = $termStorage->load($value['target_id']);
              if ($author) {
                if ($author->vid->value == 'person') {
                  // Assummes format GIVEN [MIDDLE] FAMILY.
                  // @todo improve.
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
            $term = $termStorage->load($values[0]['target_id']);
            if ($term) {
              $result['publisher'] = $term->label();
            }
            break;

          case 'field_edtf_date_issued':
          case 'field_edtf_date':
            $value = strip_tags($values[0]['value']);
            $result['issued']['date-parts'][] = explode('-', $value);
            break;

          case 'nid':
            $nid = $values[0]['value'];
            $node = $nodeStorage->load($nid);
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
}
else {
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
      $result = [];
      $entityTypeManager = \Drupal::service('entity_type.manager');
      $nodeStorage = $entityTypeManager->getStorage('node');
      $termStorage = $entityTypeManager->getStorage('taxonomy_term');
      foreach ($data as $field => $values) {
        if (empty($values)) {
          continue;
        }
        switch ($field) {
          case 'title':
            $result['title'] = strip_tags($values[0]['value']);
            break;

          case 'field_linked_agent':
            foreach ($values as $value) {
              $author = $termStorage->load($value['target_id']);
              if ($author) {
                if ($author->vid->value == 'person') {
                  // Assummes format GIVEN [MIDDLE] FAMILY.
                  // @todo improve.
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
            $term = $termStorage->load($values[0]['target_id']);
            if ($term) {
              $result['publisher'] = $term->label();
            }
            break;

          case 'field_edtf_date_issued':
          case 'field_edtf_date':
            $value = strip_tags($values[0]['value']);
            $result['issued']['date-parts'][] = explode('-', $value);
            break;

          case 'nid':
            $nid = $values[0]['value'];
            $node = $nodeStorage->load($nid);
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
}
