<?php

namespace Drupal\shruthi_exercise\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Define the "custom field".
 *
 * @FieldWidget(
 *   id = "cus_field_widget",
 *   label = @Translation("Custom Field Widget"),
 *   description = @Translation("Desc for Custom Field Widget"),
 *   field_types = {
 *     "custom_field"
 *   }
 * )
 */
class CusFieldWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // Renders the form for field.
    // Checks if the value exists for that field.
    $value = $items[$delta]->value ?? "";
    $element = $element + [
      '#type' => 'textfield',
      '#suffix' => "<span>" . $this->getFieldSetting("moreinfo") . "</span>",
      '#default_value' => $value,
      '#attributes' => [
        'testplacer' => $this->getSetting('textplacer'),
      ],
    ];
    // Returns the value.
    return ['value' => $element];
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    // Default settings for field widget.
    return [
      'textplacer' => 'none',
    // Calling the function from parent class.
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    // Form to configure settings.
    $element['textplacer'] = [
      '#type' => 'textfield',
      '#title' => 'text placer',
      '#default_value' => $this->getSetting('textplacer'),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    // Gives the summary of what settings is been applied.
    $summary = [];
    // Adds a translated string with a placeholder value to an array.
    $summary[] = $this->t("textplacer text: @textplacer", ["@textplacer" => $this->getSetting("textplacer")]);
    return $summary;
  }

}
