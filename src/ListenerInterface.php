<?php

namespace Xudid\EventDispatcher;


/**
 * Class Listener
 * @package Xudid\EventDispatcher
 */
interface ListenerInterface
{
    public static function compare(ListenerInterface $listener1, ListenerInterface $listener2);

    public function handle(array $args = []);

    public function getCallback(): mixed;

    public function getPriority(): int;

    /**
     * Set a listener execute callback only once
     */
    public function once(): ListenerInterface;

    /**
     * Is the listener must execute the callback once
     * @return bool
     */
    public function isOnce(): bool;

    /**
     * Was the callback already executed
     */
    public function called(): bool;

    public function execute(array $args);
}