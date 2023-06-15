<?php

namespace Drupal\shruthi_exercise\Controller;

use Drupal\shruthi_exercise\CustomServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

// Defines namespace for controller of this module.
// Imports the class files in php.
use Drupal\Core\Controller\ControllerBase;

/**
 * Inherits Parent class.
 */
class CustomController extends ControllerBase {

  /**
   * Extension of the class.
   */
  public function __construct(CustomServiceInterface $customService) {
    $this->customService = $customService;
  }

  /**
   * Create function.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('shruthi_exercise.custom_service')
    );
  }

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
