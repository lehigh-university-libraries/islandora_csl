<?php

/**
 * @file
 * Contains islandora_csl.tokens.inc.
 *
 * Provides tokens for CSL citation data.
 */

use Drupal\Core\Render\BubbleableMetadata;

/**
 * Implements hook_token_info().
 */
function islandora_csl_token_info() {
  $type = [
    'name' => t('Islandora CSL Tokens'),
    'description' => t('Tokens for CSL citation data from Islandora objects.'),
    'needs-data' => 'node',
  ];

  $tokens = [];
  $tokens['csl-authors'] = [
    'name' => t('CSL Authors'),
    'description' => t('Comma-separated list of author names from linked agents (creators and authors only).'),
  ];
  $tokens['csl-authors-structured'] = [
    'name' => t('CSL Authors (Structured)'),
    'description' => t('JSON array of author objects with given/family name structure for Schema.org.'),
  ];
  $tokens['csl-date-issued'] = [
    'name' => t('CSL Date Issued'),
    'description' => t('ISO 8601 formatted date issued.'),
  ];
  $tokens['csl-doi'] = [
    'name' => t('CSL DOI'),
    'description' => t('DOI identifier extracted from the identifier field.'),
  ];
  $tokens['csl-json'] = [
    'name' => t('CSL JSON'),
    'description' => t('Complete CSL-JSON data for the node.'),
  ];

  return [
    'types' => ['islandora_csl' => $type],
    'tokens' => ['islandora_csl' => $tokens],
  ];
}

/**
 * Implements hook_tokens().
 */
function islandora_csl_tokens($type, $tokens, array $data, array $options, BubbleableMetadata $bubbleable_metadata) {
  $replacements = [];

  if ($type !== 'islandora_csl' || empty($data['node'])) {
    return $replacements;
  }

  $node = $data['node'];

  // Skip during node CUD operations - only process for rendered output.
  if ($node->isNew() || !$node->id()) {
    return $replacements;
  }

  // Skip if not viewing a page (e.g., during save, API calls).
  $route_match = \Drupal::routeMatch();
  $route_name = $route_match->getRouteName();
  if ($route_name && !str_starts_with($route_name, 'entity.node.canonical')) {
    return $replacements;
  }

  if ($node->bundle() !== 'islandora_object') {
    return $replacements;
  }

  // Static cache to avoid repeated encoding.
  $csl_cache = &drupal_static(__FUNCTION__, []);
  $nid = $node->id();

  if (!isset($csl_cache[$nid])) {
    $encoder = \Drupal::service('islandora_csl.encoder');
    $csl_cache[$nid] = [
      'str' => $encoder->encode($node->toArray()),
    ];
    $csl_cache[$nid]['data'] = json_decode($csl_cache[$nid]['str'], TRUE);
  }

  $csl_str = $csl_cache[$nid]['str'];
  $csl_data = $csl_cache[$nid]['data'];

  foreach ($tokens as $name => $original) {
    switch ($name) {
      case 'csl-authors':
        if (!empty($csl_data['author'])) {
          $authors = [];
          foreach ($csl_data['author'] as $author) {
            if (!empty($author['given']) && !empty($author['family'])) {
              $authors[] = $author['given'] . ' ' . $author['family'];
            }
            elseif (!empty($author['family'])) {
              $authors[] = $author['family'];
            }
          }
          $replacements[$original] = implode(', ', $authors);
        }
        else {
          $replacements[$original] = '';
        }
        break;

      case 'csl-authors-structured':
        if (!empty($csl_data['author'])) {
          $authors = [];
          foreach ($csl_data['author'] as $author) {
            $structured = ['@type' => 'Person'];
            if (!empty($author['given'])) {
              $structured['givenName'] = $author['given'];
            }
            if (!empty($author['family'])) {
              $structured['familyName'] = $author['family'];
            }
            if (!empty($author['given']) && !empty($author['family'])) {
              $structured['name'] = $author['given'] . ' ' . $author['family'];
            }
            elseif (!empty($author['family'])) {
              $structured['name'] = $author['family'];
            }
            $authors[] = $structured;
          }
          $replacements[$original] = json_encode($authors);
        }
        else {
          $replacements[$original] = '';
        }
        break;

      case 'csl-date-issued':
        if (!empty($csl_data['issued']['date-parts'][0])) {
          $date_parts = $csl_data['issued']['date-parts'][0];
          $date = $date_parts[0];
          if (!empty($date_parts[1])) {
            $date .= '-' . str_pad($date_parts[1], 2, '0', STR_PAD_LEFT);
          }
          if (!empty($date_parts[2])) {
            $date .= '-' . str_pad($date_parts[2], 2, '0', STR_PAD_LEFT);
          }
          $replacements[$original] = $date;
        }
        else {
          $replacements[$original] = '';
        }
        break;

      case 'csl-doi':
        $replacements[$original] = $csl_data['DOI'] ?? '';
        break;

      case 'csl-json':
        $replacements[$original] = $csl_str;
        break;
    }
  }

  return $replacements;
}
