<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_is_part_of' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_is_part_of",
 *   label = @Translation("isPartOf"),
 *   description = @Translation("The publication this article is part of (e.g., journal name)."),
 *   name = "isPartOf",
 *   group = "schema_scholarly_article",
 *   weight = 6,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 *   tree_parent = {},
 *   tree_depth = -1,
 * )
 */
class SchemaScholarlyArticleIsPartOf extends SchemaNameBase {

}
