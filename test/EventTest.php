<?php


use Psr\EventDispatcher\StoppableEventInterface;
use Xudid\EventDispatcher\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{

    public function test__construct()
    {
        $event = new Event('', '');
        $this->assertInstanceOf(StoppableEventInterface::class, $event);
    }

    public function testGetData()
    {
        $event = new Event('', '');
        $this->assertEquals('', $event->getData());

        $event = new Event('', 'azerty');
        $this->assertEquals('azerty', $event->getData());

        $event = new Event('', 123456789);
        $this->assertEquals(123456789, $event->getData());

        $event = new Event('', []);
        $this->assertEquals([], $event->getData());

        $event = new Event('', ['1', '2', '3', '4', '5']);
        $this->assertEquals(['1', '2', '3', '4', '5'], $event->getData());

        $object = (object)[];
        $event = new Event('', [$object]);
        $this->assertEquals([$object], $event->getData());
    }

    public function testGetName()
    {
        $event = new Event('', '');
        $this->assertEquals('', $event->getName());
    }

    public function testStopPropagation()
    {
        $event = new Event('', '');
        $this->assertFalse($event->isPropagationStopped());
        $event->stopPropagation();
        $this->assertTrue($event->isPropagationStopped());
    }
}
