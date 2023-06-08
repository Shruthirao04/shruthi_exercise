<?php

namespace Drupal\shruthi_exercise\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Config\ConfigCrudEvent;

/**
 * Inherits parent class.
 */
class CustomEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   *
   * @return array
   *   returns array
   */
  public static function getSubscribedEvents() {
    // Registers an event listener to handle the
    // configEvents  save event with a priority of -100.
    $events[ConfigEvents::SAVE][] = ['configSave', -100];
    $events[ConfigEvents::SAVE][] = ['configDelete', 100];
    return $events;
  }

  /**
   * Defines function of configsave.
   */
  public function configSave(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    // Displays a message of the event saved.
    \Drupal::messenger()->addStatus('Saved config: ' . $config->getName());
  }

  /**
   * Defines function of configdelete.
   */
  public function configDelete(ConfigCrudEvent $event) {
    // Gets the events.
    $config = $event->getConfig();
    // Updates with delete message when the event is deleted.
    \Drupal::messenger()->addStatus('Deleted config: ' . $config->getName());
  }

}
