<?php

namespace Drupal\shruthi_exercise\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Define the "custom field".
 *
 * @FieldType(
 *   id = "custom_field",
 *   label = @Translation("Custom Field"),
 *   description = @Translation("Desc for Custom Field"),
 *   category = @Translation("Text")
 *   default_widget = "cus_field_widget",
 * )
 */

class CusFieldType extends FieldItemBase {

    /**
     * {@inheritdoc}
     */

    public static function schema(FieldStorageDefinitionInterface $field_definition) { //responsible for defining and managing database schemas for a specific field.
        return [
            'columns' => [
                'value' => [
                    'type' => 'varchar',
                    'length' => $field_definition->getSetting("length"),
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultStorageSettings() { //provides a storage settings to the field with length 255
        return [
            'length' => 255,
        ] + parent::defaultStorageSettings(); //calling the defaultStorageSettings() method of the parent class.
    }

    /**
     * {@inheritdoc}
     */
    public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) { //generates a form element for configuring the "length" setting, which can be used to capture user input and store it for later use in the field's storage settings.
        $element = [];

        $element['length'] = [
            '#type' => 'number',
            '#title' => t("Required Length"),
            '#required' => TRUE,
            '#default_value' => $this->getSetting("length"), //retrieves the stored value for the "length" setting.
        ];
        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultFieldSettings() { //manages the field settings
        return [
            'moreinfo' => "Give information",
        ] + parent::defaultFieldSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function fieldSettingsForm(array $form, FormStateInterface $form_state) { //creates a field settings form of the element
        $element = [];
        $element['moreinfo'] = [
            '#type' => 'textfield',
            '#title' => 'Give information',
            '#required' => TRUE,
            '#default_value' => $this->getSetting("moreinfo"),
        ];
        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public static function PropertyDefinitions(FieldStorageDefinitionInterface $field_definition) { //defines property for a particular field
        $properties['value'] = DataDefinition::create('string')->setLabel(t("Name")); //creates and assigns a name to the property

        return $properties;
    }
}