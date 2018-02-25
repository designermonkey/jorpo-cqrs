<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;

class EventHandlerTest extends TestCase
{
    public function testShouldHandleEvent()
    {
        $subject = new EventListenerDummy;
        $subject->handle(new FakeEvent());
        $this->assertTrue($subject->wasHandled());
    }

    public function testShouldErrorWhenNoEventMethodExists()
    {
        $this->expectException(BadMethodCallException::class);
        $subject = new EventListenerDummy;
        $subject->handle(new IgnoredEvent());
    }
}
