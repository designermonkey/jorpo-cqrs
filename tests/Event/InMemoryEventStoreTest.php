<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use Throwable;
use Ds\Map;
use Ds\Set;
use PHPUnit\Framework\TestCase;
use Jorpo\Cqrs\ObjectName;
use Jorpo\Cqrs\Event\Exception\ConcurrencyException;
use Jorpo\Cqrs\Event\Exception\IdentifierNotFoundException;
use Jorpo\ValueObject\Identity\Uuid;

class InMemoryEventStoreTest extends TestCase
{
    const FAKE_NAMESPACE = 'Fake\\Space';

    public function testShouldStoreAndGetEvents()
    {
        $subject = $this->createStore();
        $this->assertInstanceOf(EventStore::class, $subject);

        $subject->storeEvents(
            $type = new ObjectName(self::FAKE_NAMESPACE),
            $identity = Uuid::generate(),
            new Set([
                $event = new FakeEventOne(['version' => 1])
            ])
        );

        $events = $subject->getEvents($type, $identity);

        $this->assertCount(1, $events);
        $this->assertContains($event, iterator_to_array($events));
    }

    public function testShouldStoreAndGetMultipleEvents()
    {
        $subject = $this->createStore();

        $subject->storeEvents(
            $type = new ObjectName(self::FAKE_NAMESPACE),
            $identity = Uuid::generate(),
            new Set([
                $eventOne = new FakeEventOne(['version' => 1])
            ])
        );
        $subject->storeEvents(
            $type,
            $identity,
            new Set([
                $eventTwo = new FakeEventOne(['version' => 2])
            ])
        );

        $events = $subject->getEvents($type, $identity);

        $this->assertContains($eventOne, iterator_to_array($events));
        $this->assertContains($eventTwo, iterator_to_array($events));
    }

    public function testShouldOnlyStoreEventsOnce()
    {
        $subject = $this->createStore();

        $subject->storeEvents(
            $type = new ObjectName(self::FAKE_NAMESPACE),
            $identity = Uuid::generate(),
            new Set([
                $eventOne = new FakeEventOne(['version' => 1])
            ])
        );
        $subject->storeEvents(
            $type,
            $identity,
            new Set([
                $eventTwo = new FakeEventOne(['version' => 2])
            ])
        );
        $subject->storeEvents(
            $type,
            $identity,
            new Set([
                $eventOne
            ])
        );

        $events = $subject->getEvents($type, $identity);

        $this->assertContains($eventOne, iterator_to_array($events));
        $this->assertContains($eventTwo, iterator_to_array($events));
        $this->assertSame(2, count($events));
    }

    public function testShouldThrowExceptionWhenIdentifierNotFoundOnGetEvents()
    {
        $this->expectException(IdentifierNotFoundException::class);
        ($this->createStore())->getEvents(new ObjectName(self::FAKE_NAMESPACE), Uuid::generate());
    }

    public function testShouldNotifyAnEventBusAfterStore()
    {
        $subject = $this->createStore($bus = new InMemoryEventBus());
        $bus->register($handler = $this->createHandler());

        $this->assertEquals(0, $handler->getCallCount());

        $subject->storeEvents(
            new ObjectName(self::FAKE_NAMESPACE),
            Uuid::generate(),
            new Set([
                new FakeEventOne(['version' => 1])
            ])
        );

        $this->assertEquals(1, $handler->getCallCount());
    }

    public function testShouldThrowConcurrencyExceptionWhenVersionsNotMatch()
    {
        $this->expectException(ConcurrencyException::class);

        $subject = $this->createStore();

        $event = new FakeEventOne(['version' => 10]);
        $subject->storeEvents(
            new ObjectName(self::FAKE_NAMESPACE),
            Uuid::generate(),
            new Set([$event])
        );
    }

    public function testShouldNotSaveEventIfBusThrowsException()
    {
        $this->expectException(IdentifierNotFoundException::class);

        $subject = $this->createStore(
            new ThrowingEventBus
        );
        $event = new FakeEventOne(['version' => 1]);

        try {
            $subject->storeEvents(
                $type = new ObjectName(self::FAKE_NAMESPACE),
                $identity = Uuid::generate(),
                new Set([$event])
            );
        } catch (Throwable $error) {
            $subject->getEvents($type, $identity);
        }
    }

    private function createStore($bus = null)
    {
        return new InMemoryEventStore($bus ?? new InMemoryEventBus);
    }

    private function createHandler()
    {
        return new FakeEventOneListener;
    }
}
