<?php

namespace Drupal\shruthi_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Inherits parent class.
 */
class CustomForm extends FormBase {

  /**
   * Generated form id.
   */
  public function getFormId() {
    return 'custom_form_get_user_details';
  }

  /**
   * Build form generates form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => 'subject',
      '#required' => TRUE,
      '#placeholder' => 'subject',
    ];
    $form['department'] = [
      '#type' => 'textfield',
      '#title' => 'department',
      '#required' => FALSE,
      '#placeholder' => 'department',
    ];
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => 'Email',
      '#default_value' => 'example@gmail.com',
    ];
    $form['age'] = [
      '#type' => 'select',
      '#title' => 'Age',
      '#options' => [
        '18plus' => '18+',
        '18minus' => '18-',
      ],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];
    return $form;
  }

  /**
   * Submit form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addMessage("User Details Submitted Successfully");
    \Drupal::database()->insert("user_details")->fields([
      'subject' => $form_state->getValue("subject"),
      'department' => $form_state->getValue("department"),
      'email' => $form_state->getValue("email"),
      'age' => $form_state->getValue("age"),
    ])->execute();
  }

}
