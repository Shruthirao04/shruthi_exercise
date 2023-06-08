<?php

namespace Drupal\shruthi_exercise;

use Drupal\Core\Config\ConfigFactory;

/**
 * Implements custom service.
 *
 * @package Drupal\shruthi_exercise\Services
 */
class CustomService {

  /**
   * Configuration Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Constructor.
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   * Gets my setting.
   */
  public function getName() {
    $config = $this->configFactory->get('shruthi_exercise.settings');
    return $config->get('branch');
  }

}
