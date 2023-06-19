<?php

namespace Drupal\shruthi_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides simple block for d4drupal.
 *
 * @Block (
 * id = "shruthi_exercise",
 * admin_label = "Config Plugin Block"
 * )
 */
class ConfigBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * The form builder service.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

    /**
   * Constructs a HelloBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, FormBuilderInterface $form_builder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $form_builder;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    // Instantiate this block class.
    return new static($configuration, $plugin_id, $plugin_definition,
      // Load the service required to construct this class.
      $container->get('form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Render function.
    $form = $this->formBuilder->getForm('\Drupal\shruthi_exercise\Form\CustomConfigForm');
    return $form;

  }

}
