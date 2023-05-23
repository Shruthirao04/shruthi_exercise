<?php

namespace Drupal\shruthi_exercise\EventSubscriber;

use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CustomConfigEvent
 * @package Drupal\shruthi_exercise\EventSubscriber
 *
 * Redirects node/add/page* to '/node/1/*'
 */
class UserRedirect implements EventSubscriberInterface {

  public function checkForRedirection(RequestEvent $event) {

    $request = $event->getRequest(); //assigns the returned request object allowing further operations to be performed on the request object using the "$request" variable.
    $path = $request->getRequestUri(); //assigns the URI of the request to the variable "$path.
    if(strpos($path, 'node/add/page') !== false) { //checks the string position of the path
      // Redirect old  urls
      $new_url = str_replace('node/add/page','node/1', $path);
      $new_response = new RedirectResponse($new_url, '301'); //redirects to the new path
      $new_response->send(); //object is sent to handle the response
    }
// This is necessary because this also gets called on
// node sub-tabs such as "edit", "revisions", etc.  This
// prevents those pages from redirected.
    if ($request->attributes->get('_route') !== 'entity.node.canonical') { //checks if the current route of the request is not equal to 'entity.node.canonical'.
        return;
      }

    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
      //The dynamic cache subscribes an event with priority 29. If you want that your code runs before that you have to use a priority >29:
      $events[KernelEvents::REQUEST][] = array('checkForRedirection', 29);
      return $events;
    }

  }