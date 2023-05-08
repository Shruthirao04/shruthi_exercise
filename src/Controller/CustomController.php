<?php
namespace Drupal\shruthi_exercise\Controller; #defines namespace for controller of this module
use Drupal\Core\Controller\ControllerBase; #imports the class files in php
use Drupal\shruthi_exercise\CustomService;
class CustomController extends ControllerBase{ #extension of the class
    public function hello() {
        $data = \Drupal::service('custom_service')->getName();
        return[
        '#theme'=> "shruthi_template", #theme name
        '#markup' => $data, #static text
        '#hexcode'=> '#FF0000', #html hexcode value
    ];
}
}
