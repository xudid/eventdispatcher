<?php


use Xudid\EventDispatcher\Event;
use Xudid\EventDispatcher\Listener;
use Xudid\EventDispatcher\ListenerProvider;
use PHPUnit\Framework\TestCase;

class ListenerProviderTest extends TestCase
{
    public function testGetListenersForEventReturnIterable()
    {
        $provider = new ListenerProvider();

        $event = new Event('aze');
        $result = $provider->getListenersForEvent($event);
        $this->assertTrue(is_iterable($result));
    }

    public function testGetListenersForEventReturnAddedListenersForThisEventName()
    {
        $provider = new ListenerProvider();
        $listener = new Listener(function(){});
        $listener2 = new Listener(function(){});
        $listener3 = new Listener(function(){});
        $provider->on('aze', $listener);
        $provider->on('aze', $listener2);
        $provider->on('qsd', $listener3);

        $event = new Event('aze');
        $result = $provider->getListenersForEvent($event);
        $this->assertCount(2, $result);

        $event = new Event('qsd');
        $result = $provider->getListenersForEvent($event);
        $this->assertCount(1, $result);
    }

    public function testListenersAreOrderedByPriority()
    {
        $provider = new ListenerProvider();
        $listener = new Listener(function(){}, 2);
        $listener2 = new Listener(function(){}, 3);
        $listener3 = new Listener(function(){}, 1);
        $provider->on('aze', $listener);
        $provider->on('aze', $listener2);
        $provider->on('aze', $listener3);

        $event = new Event('aze');
        $result = $provider->getListenersForEvent($event);
        $this->assertEquals(3, $result[0]->getPriority());
        $this->assertEquals(2, $result[1]->getPriority());
        $this->assertEquals(1, $result[2]->getPriority());
    }
}
