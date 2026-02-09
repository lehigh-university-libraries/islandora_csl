<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_type' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_type",
 *   label = @Translation("@type"),
 *   description = @Translation("The type of article. Should be ScholarlyArticle."),
 *   name = "@type",
 *   group = "schema_scholarly_article",
 *   weight = -10,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "type",
 *   tree_parent = {
 *     "ScholarlyArticle",
 *   },
 *   tree_depth = -1,
 * )
 */
class SchemaScholarlyArticleType extends SchemaNameBase {

}
