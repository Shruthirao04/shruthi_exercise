<?php

namespace Drupal\shruthi_exercise\EventSubscriber;

// Used as baseclass for EventSubcriberDemo.
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
// Defines event for the configuration system.
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Description for class.
 */
class EventsSubscriberDemo implements EventSubscriberInterface {
  /**
   * Extending the baseclass.
   *
   * @var Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Function.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   *
   * @return array
   *  returns array
   */
  public static function getSubscribedEvents() {
    // Returns the configuration when it saved.
    $events[ConfigEvents::SAVE][] = ['configSave', -100];
    // Returns the configuration when it is deleted.
    $events[ConfigEvents::DELETE][] = ['configDelete', 100];
    return $events;
  }

  /**
   * Configsave function.
   */
  public function configSave(ConfigCrudEvent $event) {
    // Return the Config Object.
    $config = $event->getConfig();
    // Messenger service is called.
    $this->messenger->addMessage('Saved config: ' . $config->getName());
  }

  /**
   * Configdelete function.
   */
  public function configDelete(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    $this->messenger->addMessage('Deleted config: ' . $config->getName());
  }

}