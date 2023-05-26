<?php

namespace Xudid\EventDispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Class ListenerProvider
 * @package Xudid\EventDispatcher
 */
class ListenerProvider implements ListenerProviderInterface
{
    private array $listeners = [];

    public function on(string $name, $listener)
    {
        $this->addListener($listener, $name);
        $this->sortListenersByPriority($name);
    }

    public function getListenersForEvent(object $event): iterable
    {
        $key = $event->getName();

        if (!$this->hasListeners($key)) {
            return [];
        }

        return $this->listeners[$key];
    }

    private function addListener($listener, $name)
    {
        $this->listeners[$name][] = $listener;
    }

    private function sortListenersByPriority($name)
    {
        $listeners = $this->listeners[$name];
        usort($listeners, function ($listenerA, $listenerB) {
            return Listener::compare($listenerA, $listenerB);
        });

        $this->listeners[$name] = $listeners;
    }

    public function hasListeners($key): bool
    {
        return array_key_exists($key, $this->listeners);
    }
}
