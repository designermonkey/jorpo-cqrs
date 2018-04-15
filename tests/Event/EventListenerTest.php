<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;

class EventListenerTest extends TestCase
{
    public function testShouldHaveEventHandlerMethod()
    {
        $subject = new FakeEventOneListener;

        $subject->handle(new FakeEventOne());
        $this->assertTrue($subject->wasHandled());
    }

    public function testShouldFallbackToCatchAllEventHandlerMethod()
    {
        $subject = new class extends EventListener
        {
            use EventListenerTestTrait;

            public function onAnyEvent()
            {
                $this->markHandled();
            }
        };

        $subject->handle(new FakeEventOne());
        $this->assertTrue($subject->wasHandled());
    }

    public function testShouldErrorWhenNoEventMethodExists()
    {
        $this->expectException(BadMethodCallException::class);
        $subject = new FakeEventListener;
        $subject->handle(new FakeEventTwo());
    }
}
