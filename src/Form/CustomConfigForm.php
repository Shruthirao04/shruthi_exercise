<?php

namespace Drupal\shruthi_exercise\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomConfigForm extends ConfigFormBase {

    /**
     * Settings Variable.
     */
    Const CONFIGNAME = "shruthi_exercise.settings"; #defines new php constant

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return "shruthi_exercise_settings"; #returns form id
    }

    /**
     * {@inheritdoc}
     */

    protected function getEditableConfigNames() { #this function returns array of config obj
        return [
            static::CONFIGNAME,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) { #creates a form
        $config = $this->config(static::CONFIGNAME); #used to load config obj then to retieve&modify data
        $form['branch'] = [
            '#type' => 'textfield',
            '#title' => 'branch',
            '#attached' => [
                'library' => [
                    'shruthi_exercise/css_lib',
                ],
            ],
            '#default_value' => $config->get("branch"), #sets the default value
        ];

        $form['batch'] = [
            '#type' => 'textfield',
            '#title' => 'batch',
            '#default_value' => $config->get("batch"),
        ];

        return Parent::buildForm($form, $form_state); #returns the form
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) { #function for submitting form
        $config = $this->config(static::CONFIGNAME);
        $config->set("branch", $form_state->getValue('branch')); #sets the value of a config key to the value submitted in a form field
        $config->set("batch", $form_state->getValue('batch'));
        $config->save(); #saves the form values
    }

}