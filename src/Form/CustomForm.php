<?php

namespace Drupal\shruthi_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Inherits parent class.
 */
class CustomForm extends FormBase {
  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The database service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * CustomForm constructor.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\Database\Connection $database
   *   The database service.
   */
  public function __construct(MessengerInterface $messenger, Connection $database) {
    $this->messenger = $messenger;
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('database')
    );
  }

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
 * {@inheritdoc}
 */
/*
public function validateForm(array &$form, FormStateInterface $form_state) {
  if (strlen($form_state->getValue('subject')) < 3) {
    $form_state->setErrorByName('subject', $this->t('The subject is too short.'));
  }
}
*/
public function validateForm(array &$form, FormStateInterface $form_state) {
$email = $form_state->getValue('email');
  $pattern = '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}';
  if (!preg_match('/' . $pattern . '/', $email)) {
    $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
  }
}

  /**
   * Submit form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger->addMessage("User Details Submitted Successfully");
    $this->database->insert("user_details")->fields([
      'subject' => $form_state->getValue("subject"),
      'department' => $form_state->getValue("department"),
      'email' => $form_state->getValue("email"),
      'age' => $form_state->getValue("age"),
    ])->execute();
  }

}
