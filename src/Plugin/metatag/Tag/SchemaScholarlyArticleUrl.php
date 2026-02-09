<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_url' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_url",
 *   label = @Translation("url"),
 *   description = @Translation("The URL of the article."),
 *   name = "url",
 *   group = "schema_scholarly_article",
 *   weight = 5,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "url",
 *   tree_parent = {},
 *   tree_depth = -1,
 * )
 */
class SchemaScholarlyArticleUrl extends SchemaNameBase {

}
