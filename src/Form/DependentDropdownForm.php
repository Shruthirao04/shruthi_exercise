<?php

namespace Drupal\shruthi_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;


class DependentDropdownForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dependent_dropdown_Form'; //returns the formid
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) { # return value of the function location(), which provides options for the first dropdown field (category).
    $opt = $this->location();
    $cat = $form_state->getValue('category') ?: 'none';
    $avai = $form_state->getValue('availableitems') ?: 'none';
    $form['category'] = [
        '#type' => 'select',
        '#title' => 'country',
        '#options' => $opt,
        'default_value' => $cat,
        '#ajax' => [ //ajax enabled
            'callback' => '::DropdownCallback', //handle responses from the server in Ajax for that function
            'wrapper' => 'field-container', //upon this which element will get alter
            'event' => 'change' //type of event for select option
        ]
    ];
    $form['availableitems'] = [
        '#type' => 'select',
        '#title' => 'state',
        '#options' =>static::availableItems($cat),
        '#default_value' => !empty($form_state->getValue('availableitems')) ? $form_state->getValue('availableitems') : 'none',
        '#prefix' => '<div id="field-container"',
        '#suffix' => '</div>',
        '#ajax' => [
          'callback' => '::DropdownCallback',
          'wrapper' => 'dist-container',
          'event' => 'change'
      ]
    ];
    $form['district'] = [
          '#type' => 'select',
          '#title' => 'district',
          '#options' =>static::district($avai),
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
  public function submitForm(array &$form, FormStateInterface $form_state) { //submitform function used after entering the form values and submits
    $trigger = (string) $form_state->getTriggeringElement()['#value'];
    if ($trigger != 'submit') {
        $form_state->setRebuild();
    }
  }

  public function DropdownCallback(array &$form, FormStateInterface $form_state) { //this function is triggered when category or avail dropdown changes
    $triggering_element = $form_state->getTriggeringElement();
    $triggering_element_name = $triggering_element['#name'];

    if ($triggering_element_name === 'category') {
      return $form['availableitems'];
    }
    elseif ($triggering_element_name === 'availableitems') {
      return $form['district'];
    }


  }

  public function location() { //options for location function
    return [
        'none' => '-none-',
        'america' => 'america',
    ];
  }

  public function availableItems($cat) { //options for availableitems function
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

  public function district($avai) { //options for district function
    switch($avai) {
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