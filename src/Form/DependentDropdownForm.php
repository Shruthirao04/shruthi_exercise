<?php

namespace Drupal\shruthi_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Inherits parent class.
 */
class DependentDropdownForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    // Returns the formid.
    return 'dependent_dropdown_Form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Return value of the function location(),
    // which provides options for the first dropdown field (category).
    $opt = $this->location();
    $cat = $form_state->getValue('category') ?: 'none';
    $avai = $form_state->getValue('availableitems') ?: 'none';
    $form['category'] = [
      '#type' => 'select',
      '#title' => 'country',
      '#options' => $opt,
      'default_value' => $cat,
    // Ajax enabled.
      '#ajax' => [
    // Handle responses from the server in Ajax for that function.
        'callback' => '::DropdownCallback',
    // Upon this which element will get alter.
        'wrapper' => 'field-container',
    // Type of event for select option.
        'event' => 'change',
      ],
    ];
    $form['availableitems'] = [
      '#type' => 'select',
      '#title' => 'state',
      '#options' => static::availableItems($cat),
      '#default_value' => !empty($form_state->getValue('availableitems')) ? $form_state->getValue('availableitems') : 'none',
      '#prefix' => '<div id="field-container"',
      '#suffix' => '</div>',
      '#ajax' => [
        'callback' => '::DropdownCallback',
        'wrapper' => 'dist-container',
        'event' => 'change',
      ],
    ];
    $form['district'] = [
      '#type' => 'select',
      '#title' => 'district',
      '#options' => static::district($avai),
      '#default_value' => !empty($form_state->getValue('district')) ? $form_state->getValue('district') : '',
      '#prefix' => '<div id="dist-container"',
      '#suffix' => '</div>',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Submitform function used after entering the form values and submits.
    $trigger = (string) $form_state->getTriggeringElement()['#value'];
    if ($trigger != 'submit') {
      $form_state->setRebuild();
    }
  }

  /**
   * Implements the dropdown function.
   */
  public function dropdowncallback(array &$form, FormStateInterface $form_state) {
    // This function is triggered when category or avail dropdown changes.
    $triggering_element = $form_state->getTriggeringElement();
    $triggering_element_name = $triggering_element['#name'];

    if ($triggering_element_name === 'category') {
      return $form['availableitems'];
    }
    elseif ($triggering_element_name === 'availableitems') {
      return $form['district'];
    }

  }

  /**
   * Location takes the variables of location.
   */
  public function location() {
    // Options for location function.
    return [
      'none' => '-none-',
      'america' => 'america',
    ];
  }

  /**
   * Availableitems takes the variables of location.
   */
  public function availableItems($cat) {
    // Options for availableitems function.
    switch ($cat) {
      case 'america':
        $opt = [
          'california' => 'california',
          'florida' => 'florida',
        ];
        break;

      default:
        $opt = ['none' => '-none-'];
        break;
    }
    return $opt;
  }

  /**
   * District takes the variables of location.
   */
  public function district($avai) {
    // Options for district function.
    switch ($avai) {
      case 'california':
        $opt = [
          'solano' => 'solano',
          'sonoma' => 'sonoma',
          'napa' => 'napa',
        ];
        break;

      case 'florida':
        $opt = [
          'pasco county' => 'pasco county',
          'sarasota' => 'sarasota',
        ];
        break;
    }
    return $opt;
  }

}
