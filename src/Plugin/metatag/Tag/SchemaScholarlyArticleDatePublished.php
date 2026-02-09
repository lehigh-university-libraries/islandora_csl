<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_date_published' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_date_published",
 *   label = @Translation("datePublished"),
 *   description = @Translation("The date the article was published."),
 *   name = "datePublished",
 *   group = "schema_scholarly_article",
 *   weight = 2,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "date",
 *   tree_parent = {},
 *   tree_depth = -1,
 * )
 */
class SchemaScholarlyArticleDatePublished extends SchemaNameBase {

}
