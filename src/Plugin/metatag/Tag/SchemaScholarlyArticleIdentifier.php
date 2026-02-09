<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_identifier' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_identifier",
 *   label = @Translation("identifier"),
 *   description = @Translation("The DOI or other identifier for the article."),
 *   name = "identifier",
 *   group = "schema_scholarly_article",
 *   weight = 4,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 *   tree_parent = {},
 *   tree_depth = -1,
 * )
 */
class SchemaScholarlyArticleIdentifier extends SchemaNameBase {

}
