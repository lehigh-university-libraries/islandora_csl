<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_name' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_name",
 *   label = @Translation("name"),
 *   description = @Translation("The name/title of the scholarly article."),
 *   name = "name",
 *   group = "schema_scholarly_article",
 *   weight = 0,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 *   tree_parent = {},
 *   tree_depth = -1,
 * )
 */
class SchemaScholarlyArticleName extends SchemaNameBase {

}
