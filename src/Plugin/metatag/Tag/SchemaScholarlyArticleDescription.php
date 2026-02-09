<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_description' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_description",
 *   label = @Translation("description"),
 *   description = @Translation("A description or abstract of the scholarly article."),
 *   name = "description",
 *   group = "schema_scholarly_article",
 *   weight = 1,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 *   tree_parent = {},
 *   tree_depth = -1,
 * )
 */
class SchemaScholarlyArticleDescription extends SchemaNameBase {

}
