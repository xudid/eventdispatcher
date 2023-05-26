<?php


use Psr\EventDispatcher\EventDispatcherInterface;
use Xudid\EventDispatcher\Dispatcher;
use PHPUnit\Framework\TestCase;
use Xudid\EventDispatcher\Event;
use Xudid\EventDispatcher\Listener;
use Xudid\EventDispatcher\ListenerProvider;

class DispatcherTest extends TestCase
{

    private function makeDispatcher()
    {
        $listenerProvider = new ListenerProvider();
        $dispatcher = new Dispatcher($listenerProvider);

        return $dispatcher;
    }
    public function test__construct()
    {
        $dispatcher = $this->makeDispatcher();
        $this->assertInstanceOf(EventDispatcherInterface::class, $dispatcher);
    }

    public function testDispatchReturnEvent()
    {
        $dispatcher = $this->makeDispatcher();
        $event = new Event('aze');
        $outputEvent = $dispatcher->dispatch($event);
        $this->assertEquals('aze', $outputEvent->getName());
    }


    public function testOnce()
    {
        $dispatcher = $this->makeDispatcher();
        $listenerBuilder = $this->getMockBuilder(Listener::class)->onlyMethods(['execute']);
        $listener = $listenerBuilder->setConstructorArgs([function(){}])->getMock();
        $listener->expects($this->once())->method('execute');
        $dispatcher->once('aze', $listener);
        $dispatcher->dispatch(new Event('aze'));
        $dispatcher->dispatch(new Event('aze'));
    }

    public function testOn()
    {
        $dispatcher = $this->makeDispatcher();
        $event = new Event('aze');
        $outputEvent = $dispatcher->dispatch($event);
        $this->assertEquals('aze', $outputEvent->getName());
    }
}
