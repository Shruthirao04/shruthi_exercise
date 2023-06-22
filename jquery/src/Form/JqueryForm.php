<?php

namespace Drupal\jquery\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements the MyForm form controller.
 */
class JqueryForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'my_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $attachments['#attached']['library'][] = 'jquery/js_lib';
    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('firstname'),
      '#attributes' => ['id' => 'first-name'],
    ];

    $form['same_firstname'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('same as above'),
      '#attributes' => ['id' => 'same-firstname'],
    ];


    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('lastname'),
      '#attributes' => ['id' => 'last-name'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

}