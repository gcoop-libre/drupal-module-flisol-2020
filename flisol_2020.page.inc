<?php

/**
 * @file
 * Contains flisol_2020.page.inc.
 *
 * Page callback for FLISoL 2020 page.
 */

/**
 * Prepares variables for FLISoL 2020 page templates.
 *
 * Default template: flisol-2020.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - speaker: The contact information of the speaker.
 */
function template_preprocess_flisol_2020(array &$variables) {
  $variables['logo_gcoop'] = [
    '#theme' => 'image',
    '#uri' => drupal_get_path('module', 'flisol_2020') . '/images/gcoop.png',
    '#alt' => t('gcoop Cooperativa de Software Libre'),
    '#attributes' => [
      'class' => [
        'logo-gcoop',
      ],
    ],
  ];
}
