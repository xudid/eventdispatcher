<?php

namespace Xudid\EventDispatcher;

/**
 * Class Listener
 * @package Xudid\EventDispatcher
 */
class Listener implements ListenerInterface
{
    private $callback;
    private int $priority;
    private bool $once = false;
    private bool $called = false;

    /**
     * Listener constructor.
     */
    public function __construct($callback, $priority = 0, $once = false)
    {
        $this->callback = $callback;
        $this->priority = $priority;
        $this->once = $once;
    }

    public static function compare(ListenerInterface $listener1, ListenerInterface $listener2)
    {
        if ($listener1->getPriority() == $listener2->getPriority()){
            return 0;
        }

        if ($listener1->getPriority() < $listener2->getPriority()) {
            return 1;
        }

        return -1;
    }

    public function handle(array $args = [])
    {
        if (!($this->called && $this->isOnce())) {
            $this->called = true;
            return $this->execute($args);
        }

        return;
    }

    public function getCallback(): mixed
    {
        return $this->callback;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * Set a listener execute callback only once
     */
    public function once() : ListenerInterface
    {
        $this->once = true;
        return $this;
    }

    /**
     * Is the listener must execute the callback once
     * @return bool
     */
    public function isOnce(): bool
    {
        return $this->once;
    }

    /**
     * Was the callback already executed
     */
    public function called(): bool
    {
        return $this->called;
    }

    public function execute(array $args)
    {
        return call_user_func_array($this->callback, $args);
    }
}