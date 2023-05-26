<?php


use Xudid\EventDispatcher\Listener;
use PHPUnit\Framework\TestCase;

class ListenerTest extends TestCase
{

    public function test__construct()
    {
        $listener = new Listener(function(){});
        $this->assertInstanceOf(Listener::class, $listener);
    }

    public function testHandle()
    {
        $listener = new Listener(function(){return '';});
        $result = $listener->handle();
        $this->assertEquals('', $result);

        $listener = new Listener(function(){return 'aze';});
        $result = $listener->handle();
        $this->assertEquals('aze', $result);
        $result = $listener->handle();
        $this->assertEquals('aze', $result);
    }

    public function testCompare()
    {
        $listener = new Listener(function(){return '';}, 1);
        $listener1 = new Listener(function(){return '';}, 2);

        $result = Listener::compare($listener, $listener1);
        $this->assertEquals(1, $result);

        $listener = new Listener(function(){return '';}, 2);
        $listener1 = new Listener(function(){return '';}, 1);

        $result = Listener::compare($listener, $listener1);
        $this->assertEquals(-1, $result);

        $listener = new Listener(function(){return '';}, 1);
        $listener1 = new Listener(function(){return '';}, 1);

        $result = Listener::compare($listener, $listener1);
        $this->assertEquals(0, $result);
    }

    public function testIsOnce()
    {
        $listener = new Listener(function(){return '';});
        $this->assertFalse($listener->isOnce());
        $listener->once();
        $this->assertTrue($listener->isOnce());
    }

    public function testIsNotOnceExecuteCalledSameCountThanHandle()
    {
        $listenerBuilder = $this->getMockBuilder(Listener::class)->onlyMethods(['execute']);
        $listener = $listenerBuilder->disableOriginalConstructor()
            ->getMock();
        $n = 2;
        $listener->expects($this->exactly($n))->method('execute');
        for ($i = 0; $i < $n; $i++) {
            $listener->handle([]);
        }
    }

    public function testIsOnceExecuteCallbackOnce()
    {
        $listenerBuilder = $this->getMockBuilder(Listener::class)->onlyMethods(['execute']);
        $listener = $listenerBuilder->setConstructorArgs([function(){}])->getMock();
        $listener->once();
        $listener->expects($this->once())->method('execute');
        $listener->handle([]);
        $listener->handle([]);
    }
}
