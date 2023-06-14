<?php

namespace Drupal\shruthi_exercise\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CustomConfigEvent.
 *
 * @package Drupal\shruthi_exercise\EventSubscriber
 *
 * Redirects node/add/page* to '/node/1/*'
 */
class UserRedirect implements EventSubscriberInterface {

  /**
   *
   */
  public function checkForRedirection(RequestEvent $event) {

    // Assigns the returned request object allowing further operations to be performed on the request object using the "$request" variable.
    $request = $event->getRequest();
    // Assigns the URI of the request to the variable "$path.
    $path = $request->getRequestUri();
    // Checks the string position of the path.
    if (strpos($path, 'node/add/page') !== FALSE) {
      // Redirect old  urls.
      $new_url = str_replace('node/add/page', 'node/1', $path);
      // Redirects to the new path.
      $new_response = new RedirectResponse($new_url, '301');
      // Object is sent to handle the response.
      $new_response->send();
    }
    // This is necessary because this also gets called on
    // node sub-tabs such as "edit", "revisions", etc.  This
    // prevents those pages from redirected.
    // Checks if the current route of the request is not equal to 'entity.node.canonical'.
    if ($request->attributes->get('_route') !== 'entity.node.canonical') {
      return;
    }

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // The dynamic cache subscribes an event with priority 29. If you want that your code runs before that you have to use a priority >29:
    $events[KernelEvents::REQUEST][] = ['checkForRedirection', 29];
    return $events;
  }

}
