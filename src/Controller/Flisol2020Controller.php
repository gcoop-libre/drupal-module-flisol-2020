<?php

namespace Drupal\flisol_2020\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class Flisol2020Controller.
 *
 *  Returns responses for FLISoL 2020 routes.
 */
class Flisol2020Controller extends ControllerBase {

  /**
   * Page title callback for the FLISoL 2020 page.
   *
   * @return string
   *   The page title.
   */
  public function title() {
    return $this->t('25 de abril 2020');
  }

  /**
   * Displays the FLISoL 2020 page with the information of the speaker.
   *
   * @return array
   *   A render array with the information of the speaker.
   */
  public function page() {
    $config = $this->config('flisol_2020.settings');

    $build = [
      '#theme' => 'flisol_2020',
      '#speaker' => $config->get('speaker'),
      '#attached' => [
        'library' => [
          'flisol_2020/flisol_2020',
        ],
      ],
      '#cache' => [
        'tags' => $config->getCacheTags(),
      ],
    ];

    return $build;
  }

}
