<?php

namespace Drupal\islandora_csl\Plugin\metatag\Tag;

use Drupal\schema_metatag\Plugin\metatag\Tag\SchemaNameBase;

/**
 * Provides a plugin for the 'schema_scholarly_article_issue_number' meta tag.
 *
 * @MetatagTag(
 *   id = "schema_scholarly_article_issue_number",
 *   label = @Translation("issueNumber"),
 *   description = @Translation("The issue number of the publication."),
 *   name = "issueNumber",
 *   group = "schema_scholarly_article",
 *   weight = 8,
 *   type = "string",
 *   secure = FALSE,
 *   multiple = FALSE,
 *   property_type = "text",
 *   tree_parent = {},
 *   tree_depth = -1,
 * )
 */
class SchemaScholarlyArticleIssueNumber extends SchemaNameBase {

}
