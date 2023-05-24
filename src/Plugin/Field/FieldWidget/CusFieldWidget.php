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

    public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) { //renders the form for field
        $value = isset($items[$delta]->value) ? $items[$delta]->value : ""; //checks if the value exists for that field
        $element = $element + [
            '#type' => 'textfield',
            '#suffix' => "<span>" . $this->getFieldSetting("moreinfo") . "</span>",
            '#default_value' => $value,
            '#attributes' => [
                'testplacer' => $this->getSetting('textplacer'),
            ],
        ];
        return ['value' => $element]; //returns the value
    }

    /**
      * {@inheritdoc}
      */
    public static function defaultSettings() { //default settings for field widget
        return [
            'textplacer' => 'none',
        ] + parent::defaultSettings(); //calling the function from parent class
    }

    /**
       * {@inheritdoc}
       */
    public function settingsForm(array $form, FormStateInterface $form_state) { //form to configure settings
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
    public function settingsSummary() { //gives the summary of what settings is been applied
        $summary = [];
        $summary[] = $this->t("textplacer text: @textplacer", array("@textplacer" => $this->getSetting("textplacer"))); //adds a translated string with a placeholder value to an array.
        return $summary;
    }


}