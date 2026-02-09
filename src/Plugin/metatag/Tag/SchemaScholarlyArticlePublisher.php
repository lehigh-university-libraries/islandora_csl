<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_publisher' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_publisher",
 *   label = @Translation("publisher"),
 *   description = @Translation("The publisher of the scholarly article."),
 *   name = "publisher",
 *   group = "schema_scholarly_article",
 *   weight = 3,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "organization",
 *   tree_parent = {
 *     "Organization",
 *   },
 *   tree_depth = 0,
 * )
 */
class SchemaScholarlyArticlePublisher extends SchemaNameBase {

}
