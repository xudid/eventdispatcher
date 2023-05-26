<?php

namespace Xudid\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Class Dispatcher
 * @package Xudid\EventDispatcher
 */
class Dispatcher implements EventDispatcherInterface
{
    private ListenerProviderInterface $listenerProvider;

    /**
     * Dispatcher constructor.
     */
    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    public function on(string $name, ListenerInterface $listener)
    {
        $this->listenerProvider->on($name, $listener);
    }

    public function once(string $name, ListenerInterface $listener)
    {
        $this->listenerProvider->on($name, $listener->once());
    }

    public function dispatch(object $event): mixed
    {
        foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
            $listener->handle([$event]);
            if ($event->isPropagationStopped) {
                return $event;
            }
        }
        return $event;
    }
}