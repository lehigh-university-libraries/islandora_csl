<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_author' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_author",
 *   label = @Translation("author"),
 *   description = @Translation("The author(s) of the scholarly article."),
 *   name = "author",
 *   group = "schema_scholarly_article",
 *   weight = 1,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = TRUE,
 *   property_type = "person",
 *   tree_parent = {
 *     "Person",
 *     "Organization",
 *   },
 *   tree_depth = 0,
 * )
 */
class SchemaScholarlyArticleAuthor extends SchemaNameBase {

}
