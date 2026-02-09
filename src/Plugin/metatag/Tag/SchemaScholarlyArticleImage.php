<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_image' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_image",
 *   label = @Translation("image"),
 *   description = @Translation("The primary image for the scholarly article."),
 *   name = "image",
 *   group = "schema_scholarly_article",
 *   weight = 9,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "image_object",
 *   tree_parent = {
 *     "ImageObject",
 *   },
 *   tree_depth = 0,
 * )
 */
class SchemaScholarlyArticleImage extends SchemaNameBase {

}
