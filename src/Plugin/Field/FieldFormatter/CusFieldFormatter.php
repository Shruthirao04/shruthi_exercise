<?php

namespace Drupal\shruthi_exercise\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Define the  field formatter".
 *
 * @FieldFormatter(
 *   id = "Field_formatter",
 *   label = @Translation("Field Formatter"),
 *   description = @Translation("Desc for  Field Formatter"),
 *   field_types = {
 *     "field_type"
 *   }
 * )
 */

/**
 * Annotation forFieldFormatter.
 */
class CusFieldFormatter extends FormatterBase {
  // Sets the 'concat' setting to 'Concat with ' as the default value
  // and merges these settings with the default settings of the parent class.

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'concat' => 'Concat with ',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['concat'] = [
    // Text field created.
      '#type' => 'textfield',
      '#title' => 'Concatenate with',
    // Current value of concat is retrieved using the getsettings()
    // and set as default value for form element.
      '#default_value' => $this->getSetting('concat'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t("concatenate with : @concat", ["@concat" => $this->getSetting('concat')]);
    return $summary;

    // Returns an array containing a single string
    // that describes the current setting value of 'concat'.
  }

  /**
   * {@inheritdoc}
   */

  /**
   * Generates the rendered output of the field formatter.
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#markup' => $this->getSetting('concat') . $item->value,
      ];
    }
    return $element;
    // It iterates over each item in the field and creates an element for each.
  }

}
