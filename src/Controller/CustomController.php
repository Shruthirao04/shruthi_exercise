<?php

namespace Drupal\shruthi_exercise\Controller;

// Defines namespace for controller of this module.
// Imports the class files in php.
use Drupal\Core\Controller\ControllerBase;

/**
 * Inherits Parent class.
 */
class CustomController extends ControllerBase {
  // Extension of the class.

  /**
   * Defines the service.
   */
  public function hello() {
    $data = \Drupal::service('custom_service')->getName();
    return [
    // Theme name.
      '#theme' => "shruthi_template",
    // Static text.
      '#markup' => $data,
    // Html hexcode value.
      '#hexcode' => '#FF0000',
    ];
  }

}
