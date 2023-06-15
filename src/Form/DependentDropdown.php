<?php

namespace Drupal\shruthi_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implements parent class.
 */
class DependentDropdown extends FormBase {

  /**
   * Database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a form object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dropdown_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $country_id = $form_state->getValue("country");

    $state_id = $form_state->getValue("state");

    $form['country'] = [
      // Specifies type .
      '#type' => 'select',
      // Title.
      '#title' => 'country',
      // Gives the list of country.
      '#options' => $this->getCountry(),
      '#empty_option'  => '-select-',
      '#ajax' => [
      // Function for ajax.
        'callback' => '::dropdownCallback',
      // Specifies id that will be updated with ajax response.
        'wrapper' => 'field-container',
      // Since it of type select so we use change.
        'event' => 'change',
      ],
    ];

    $form['state'] = [

      '#type' => 'select',

      '#title' => 'state',

      '#options' => $this->getState($country_id),
      '#empty_option'  => '-select-',
      '#prefix' => '<div id="field-container"',
      '#suffix' => '</div>',
      '#ajax' => [
        'callback' => '::dropdownCallback',
        'wrapper' => 'dist-container',
        'event' => 'change',
      ],
    ];

    $form['district'] = [

      '#type' => 'select',

      '#title' => 'district',

      '#options' => $this->getDistrict($state_id),
      '#empty_option'  => '-select-',
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
    $trigger = (string) $form_state->getTriggeringElement()['#value'];
    if ($trigger != 'submit') {
      // It will be triggered when value is not submitted .
      $form_state->setRebuild();
    }
  }

  /**
   * Function for ajax dropdown.
   */
  public function dropdownCallback(array &$form, FormStateInterface $form_state) {
    // This function is triggered based on the options.
    $triggering_element = $form_state->getTriggeringElement();
    $triggering_element_name = $triggering_element['#name'];

    if ($triggering_element_name === 'country') {
      // Gives state dropdown.
      return $form['state'];
    }
    elseif ($triggering_element_name === 'state') {
      // Gives district dropdown.
      return $form['district'];
    }

  }

  /**
   * Function to retrieve country options.
   */
  public function getCountry() {
    $query = Database::getConnection()->select('country', 'c');
    $query->fields('c', ['id', 'name']);
    $result = $query->execute();
    $options = [];

    foreach ($result as $row) {
      $options[$row->id] = $row->name;
    }
    return $options;
  }

  /**
   * Function to retrieve state options.
   */
  public function getState($country_id) {
    $query = Database::getConnection()->select('state', 's');
    $query->fields('s', ['id', 'country_id', 'name']);
    $query->condition('s.country_id', $country_id);
    $result = $query->execute();
    $options = [];

    foreach ($result as $row) {
      $options[$row->id] = $row->name;
    }
    return $options;
  }

  /**
   * Function to retrieve district options.
   */
  public function getDistrict($state_id) {
    $query = Database::getConnection()->select('district', 'd');
    $query->fields('d', ['id', 'state_id', 'name']);
    $query->condition('d.state_id', $state_id);
    $result = $query->execute();
    $options = [];

    foreach ($result as $row) {
      $options[$row->id] = $row->name;
    }
    return $options;
  }

}
