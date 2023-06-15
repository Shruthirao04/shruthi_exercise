<?php

namespace Drupal\shruthi_exercise\Controller;

use Drupal\shruthi_exercise\CustomServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

// Defines namespace for controller of this module.
// Imports the class files in php.
use Drupal\Core\Controller\ControllerBase;

/**
   *  Customservice.
   *
   * @var \Drupal\shruthi_exercise\CustomService
   */
    protected $customService;

/**
 * Inherits Parent class.
 */
class CustomController extends ControllerBase {

  /**
   * Extension of the class.
   */
  public function __construct(CustomServiceInterface $customService) {
    $this->customService = $customservice;
  }

  /**
   * Create function.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('custom_service')
    );
  }

  /**
   * Defines the service.
   */
  public function hello() {
    $data = $this->customService->getName();
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
