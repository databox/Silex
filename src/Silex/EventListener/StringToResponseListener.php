<?php

/*
 * This file is part of the Silex framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silex\EventListener;

use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Converts string responses to proper Response instances.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class StringToResponseListener implements EventSubscriberInterface
{

    public function onKernelView(ViewEvent $event)
    {
        $response = $event->getControllerResult();

        if (!(
            null === $response
            || is_array($response)
            || $response instanceof Response
            || (is_object($response) && !method_exists($response, '__toString'))
        )) {
            $event->setResponse(new Response((string) $response));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onKernelView', -10],
        ];
    }
}
