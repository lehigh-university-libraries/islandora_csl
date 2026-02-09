<?php

/**
 * @file
 * Post update functions for islandora_csl.
 */

/**
 * Enable schema_scholarly_article metatag group on islandora_object.
 */
function islandora_csl_post_update_enable_metatag_groups() {
  // Only run if islandora_object content type exists.
  $node_type = \Drupal::entityTypeManager()
    ->getStorage('node_type')
    ->load('islandora_object');
  if (!$node_type) {
    return;
  }

  $config = \Drupal::configFactory()->getEditable('metatag.settings');

  $entity_type_groups = $config->get('entity_type_groups') ?? [];

  // Ensure the node and islandora_object keys exist.
  if (!isset($entity_type_groups['node'])) {
    $entity_type_groups['node'] = [];
  }
  if (!isset($entity_type_groups['node']['islandora_object'])) {
    $entity_type_groups['node']['islandora_object'] = [];
  }

  // Enable the schema_scholarly_article group.
  $entity_type_groups['node']['islandora_object']['schema_scholarly_article'] = 'schema_scholarly_article';

  $config->set('entity_type_groups', $entity_type_groups);
  $config->save();
}
