<?php

namespace Drupal\shruthi_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Custom' block.
 *
 * @Block(
 *   id = "custom_task",
 *   admin_label = "new block",
 * )
 */
class CustomBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\shruthi_exercise\Form\CustomForm');
    // Renders form in a block.
    return $form;
  }

}
