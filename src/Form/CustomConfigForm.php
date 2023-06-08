<?php

namespace Drupal\shruthi_exercise\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Inherits parent class.
 */
class CustomConfigForm extends ConfigFormBase {

  /**
   * Settings Variable.
   */
  // Defines new php constant.
  const CONFIGNAME = "shruthi_exercise.settings";

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    // Returns form id.
    return "shruthi_exercise_settings";
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    // This function returns array of config obj.
    return [
      static::CONFIGNAME,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Creates a form.
    // Used to load config obj then to retieve&modify data.
    $config = $this->config(static::CONFIGNAME);
    $form['branch'] = [
      '#type' => 'textfield',
      '#title' => 'branch',
      '#attached' => [
        'library' => [
          'shruthi_exercise/css_lib',
        ],
      ],
      // Sets the default value.
      '#default_value' => $config->get("branch"),
    ];

    $form['batch'] = [
      '#type' => 'textfield',
      '#title' => 'batch',
      '#default_value' => $config->get("batch"),
    ];

    // Returns the form.
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Function for submitting form.
    $config = $this->config(static::CONFIGNAME);
    // Sets the value of a config key to the value submitted in a form field.
    $config->set("branch", $form_state->getValue('branch'));
    $config->set("batch", $form_state->getValue('batch'));
    // Saves the form values.
    $config->save();
  }

}
