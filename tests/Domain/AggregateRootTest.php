<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Domain;

use Throwable;
use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Jorpo\Cqrs\Domain\Event\AggregateDummyCreated;
use Jorpo\Cqrs\Domain\Event\AggregateValueChanged;
use Jorpo\Cqrs\Domain\Event\UnhandledAggregateEvent;
use Jorpo\ValueObject\Identity\Uuid;

class AggregateRootTest extends TestCase
{
    private $eventHistory;

    public function setUp()
    {
        $this->identity = Uuid::generate();

        $this->eventHistory = [
            new AggregateDummyCreated([
                'aggregateId' => (string) $this->identity,
                'value' => 'Some Value',
                'version' => 1,
            ]),
            new AggregateValueChanged([
                'aggregateId' => (string) $this->identity,
                'value' => 'Changed Value',
                'version' => 2,
            ]),
        ];

        $this->createEvent = [$this->eventHistory[0]];
        $this->changeEvent = [$this->eventHistory[1]];
    }

    public function testShouldApplyEventsFromHistory()
    {
        $aggregate = AggregateRootDummy::loadFromHistory($this->eventHistory);

        $this->assertTrue($this->identity->equals($aggregate->identity()));
        $this->assertSame(2, $aggregate->version());
        $this->assertSame('Changed Value', $aggregate->value);
        $this->assertFalse($aggregate->hasUncomittedEvents());
    }

    public function testShouldApplyEventFromMethodCall()
    {
        $aggregate = AggregateRootDummy::loadFromHistory($this->createEvent);
        $this->assertSame(1, $aggregate->version());

        $aggregate->changeValue('ChangedValue');
        $this->assertSame(2, $aggregate->version());
    }

    public function testShouldErrorWhenNoEventHandlerMethodIsPresent()
    {
        $this->expectException(BadMethodCallException::class);
        $history = [
            new UnhandledAggregateEvent
        ];

        AggregateRootDummy::loadFromHistory($history);
    }
}
