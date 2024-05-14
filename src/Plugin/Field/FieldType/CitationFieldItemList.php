<?php

namespace Drupal\islandora_csl\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemList;
use Drupal\Core\TypedData\ComputedItemListTrait;
use Seboettg\CiteProc\StyleSheet;
use Seboettg\CiteProc\CiteProc;


/**
 * Defines a computed field item list class for the citation field.
 */
class CitationFieldItemList extends FieldItemList {
  use ComputedItemListTrait;

  /**
   * {@inheritdoc}
   */
  protected function computeValue() {
  
    $encoder = \Drupal::service('islandora_csl.encoder');
    $node = $this->getEntity();
    $fields = $node->getFields();
    unset($fields['citation']);

    // Get the entity array without this computed field.
    $entity_array = [];
    foreach ($fields as $field_name => $field) {
      $entity_array[$field_name] = $field->getValue();
    }

    // create the citation
    $csl_str = $encoder->encode($entity_array);
    $csl = [json_decode($csl_str)];

    $style = StyleSheet::loadStyleSheet("modern-language-association");
    $citeProc = new CiteProc($style);
    $mla = $citeProc->render($csl, "bibliography");

    $this->list[0] = $this->createItem(0, trim(strip_tags($mla, "<i>")));

  }
}
