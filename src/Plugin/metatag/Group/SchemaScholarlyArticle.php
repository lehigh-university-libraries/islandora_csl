<?php

namespace Drupal\islandora_csl\Plugin\metatag\Group;

use Drupal\schema_metatag\Plugin\metatag\Group\SchemaGroupBase;

/**
 * Provides a plugin for the 'ScholarlyArticle' meta tag group.
 *
 * @MetatagGroup(
 *   id = "schema_scholarly_article",
 *   label = @Translation("Schema.org: ScholarlyArticle"),
 *   description = @Translation("Schema.org ScholarlyArticle structured data for citation rendering."),
 *   weight = 10,
 * )
 */
class SchemaScholarlyArticle extends SchemaGroupBase {

}
