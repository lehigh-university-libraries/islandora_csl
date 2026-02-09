<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_volume_number' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_volume_number",
 *   label = @Translation("volumeNumber"),
 *   description = @Translation("The volume number of the publication."),
 *   name = "volumeNumber",
 *   group = "schema_scholarly_article",
 *   weight = 7,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 *   tree_parent = {},
 *   tree_depth = -1,
 * )
 */
class SchemaScholarlyArticleVolumeNumber extends SchemaNameBase {

}
