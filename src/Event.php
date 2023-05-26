<?php

namespace Xudid\EventDispatcher;

use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Class Event
 * @package Xudid\EventDispatcher
 */
class Event implements StoppableEventInterface
{
    private string $name;
    private $data;
    private bool $stopPropagation  = false;

    /**
     * Event constructor.
     */
    public function __construct(string $name, $data = '')
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Stop this Event propagation
     */
    public function stopPropagation() : static
    {
        $this->stopPropagation = true;
        return $this;
    }

    /**
     * Return if the propagation must be stopped or not
     */
    public function isPropagationStopped(): bool
    {
        return $this->stopPropagation;
    }
}
