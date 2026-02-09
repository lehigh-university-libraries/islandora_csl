/**
 * @file
 * Client-side citation rendering using citation-js.
 */

(function (Drupal, drupalSettings, once) {
  'use strict';

  /**
   * Renders citations client-side using citation-js.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.islandoraCslClientSide = {
    attach: function (context) {
      if (typeof Cite === 'undefined') {
        return;
      }

      once('islandora-csl-render', '.islandora-csl-client', context).forEach(function (element) {
        var cslData = element.getAttribute('data-csl-json');
        var style = element.getAttribute('data-csl-style') || 'citation-apa';

        if (!cslData) {
          return;
        }

        try {
          var data = JSON.parse(cslData);
          var cite = new Cite(data);

          var output = cite.format('bibliography', {
            format: 'html',
            template: style,
            lang: 'en-US'
          });

          var outputContainer = element.querySelector('.islandora-csl-output');
          if (outputContainer) {
            outputContainer.innerHTML = output;
          }
        }
        catch (error) {
          console.error('Islandora CSL: Error rendering citation', error);
        }
      });
    }
  };

})(Drupal, drupalSettings, once);
