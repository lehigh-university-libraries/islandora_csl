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

    $mla = $this->removeDivTags($mla);

    $this->list[0] = $this->createItem(0, $mla);
  }

  /**
   * Helper function to remove <div> tags from a string.
   */
  private function removeDivTags($html) {
    $dom = new \DOMDocument();
    @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new \DOMXPath($dom);

    // Find and remove <div class="csl-bib-body"> and <div class="csl-entry">
    $divs = $xpath->query('//div[@class="csl-bib-body"] | //div[@class="csl-entry"]');
    foreach ($divs as $div) {
      while ($div->firstChild) {
        $div->parentNode->insertBefore($div->firstChild, $div);
      }
      $div->parentNode->removeChild($div);
    }

    return trim($dom->saveHTML());
  }

}
