<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use PHPUnit\Framework\TestCase;
use Jorpo\Cqrs\Event\Exception\EventHandlerNotFoundException;

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
        $this->expectException(EventHandlerNotFoundException::class);
        $subject = new FakeEventOneListener;
        $subject->handle(new FakeEventTwo());
    }
}
