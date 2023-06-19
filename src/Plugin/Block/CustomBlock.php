<?php

namespace Drupal\shruthi_exercise\Plugin\Block;

use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Custom' block.
 *
 * @Block(
 *   id = "custom_task",
 *   admin_label = "new block",
 * )
 */
class CustomBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
    $configuration,
    $plugin_id,
    $plugin_definition,
    $container->get('entity_field.manager')
    );
  }

  /**
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * Creating constructor to accept the EntityFieldManagerInterface.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityFieldManagerInterface $entityFieldManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityFieldManager = $entityFieldManager;
  }

  /**
   * Implements build function.
   */
  public function build() {

    $form = $this->entityFieldManager->getForm('Drupal\shruthi_exercise\Form\CustomForm');
    // Renders form in a block.
    return $form;
  }

}
