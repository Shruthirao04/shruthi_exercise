<?php

namespace Drupal\shruthi_exercise\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;

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
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * CustomConfigForm constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, MessengerInterface $messenger) {
    parent::__construct($config_factory);
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('messenger')
    );
  }

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
    $config = $this->config(static::CONFIGNAME)
    // Sets the value of a config key to the value submitted in a form field.
      ->set("branch", $form_state->getValue('branch'))
      ->set("batch", $form_state->getValue('batch'))
    // Saves the form values.
      ->save();
    $this->messenger->addStatus($this->t('The configuration is done.'));
  }
}