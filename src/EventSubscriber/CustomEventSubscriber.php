<?php

namespace Drupal\shruthi_exercise\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Config\ConfigCrudEvent;

class CustomEventSubscriber implements EventSubscriberInterface {
    /**
   * {@inheritdoc}
   *
   * @return array
   */
public static function getSubscribedEvents() {
    $events[ConfigEvents::SAVE][] = ['configSave', -100]; //registers an event listener to handle the configEvents  save event with a priority of -100.
    $events[ConfigEvents::SAVE][] = ['configDelete', 100];
    return $events;
    }

    public function configSave(ConfigCrudEvent $event) {
        $config = $event->getConfig();
        \Drupal::messenger()->addStatus('Saved config: ' . $config->getName()); //displays a message of the event saved
    }

    public function configDelete(ConfigCrudEvent $event) {
        $config = $event->getConfig(); //gets the events
        \Drupal::messenger()->addStatus('Deleted config: ' . $config->getName()); //updates with delete message when the event is deleted
    }

}