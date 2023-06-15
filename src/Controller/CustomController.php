<?php

namespace Drupal\shruthi_exercise\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\shruthi_exercise\CustomService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * To include custom_service.
 */
class CustomController extends ControllerBase {
  /**
   * The customservice.
   *
   * @var \Drupal\pragathi_exercise\CustomService
   */
  protected $customService;

  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('custom_service')
    );
  }

/**
   * Constructor.
   */
  public function __construct(CustomService $customService) {
    $this->customService = $customService;
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
