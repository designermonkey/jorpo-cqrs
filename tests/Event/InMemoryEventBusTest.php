<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use Ds\Map;
use Ds\Set;
use PHPUnit\Framework\TestCase;
use Jorpo\Cqrs\DifferentEvent;

class InMemoryEventBusTest extends TestCase
{
    public function setUp()
    {
        $this->bus = new InMemoryEventBus;

        $this->listenerOne = new FakeEventOneListener;
        $this->listenerTwo = new FakeEventTwoListener;
    }

    public function testShouldRegisterListenerAndPublishEvent()
    {
        $this->bus->register($this->listenerOne);

        $this->assertEquals(0, $this->listenerOne->getCallCount());

        $this->bus->publish($event = $this->createFakeEventOne());
        $this->bus->publish($event);
        $this->bus->publish($event);

        $this->assertEquals(3, $this->listenerOne->getCallCount());
    }

    public function testShouldOnlyPublishEventToRelevantListeners()
    {
        $this->bus->register($this->listenerOne);
        $this->bus->register($this->listenerTwo);
        $this->bus->register($this->listenerOneTwo = new FakeEventOneTwoListener);

        $this->assertEquals(0, $this->listenerOne->getCallCount());
        $this->assertEquals(0, $this->listenerTwo->getCallCount());
        $this->assertEquals(0, $this->listenerOneTwo->getCallCount());

        $this->bus->publish($this->createFakeEventOne());

        $this->assertEquals(1, $this->listenerOne->getCallCount());
        $this->assertEquals(0, $this->listenerTwo->getCallCount());
        $this->assertEquals(1, $this->listenerOneTwo->getCallCount());

        $this->bus->publish($this->createFakeEventTwo());

        $this->assertEquals(1, $this->listenerOne->getCallCount());
        $this->assertEquals(1, $this->listenerTwo->getCallCount());
        $this->assertEquals(2, $this->listenerOneTwo->getCallCount());

        $this->bus->publish($this->createFakeEventThree());

        $this->assertEquals(1, $this->listenerOne->getCallCount());
        $this->assertEquals(1, $this->listenerTwo->getCallCount());
        $this->assertEquals(2, $this->listenerOneTwo->getCallCount());
    }

    public function testShouldPublishEventsToListenerOnNamespaces()
    {
        $this->bus->register($this->cqrsLevelListener = new CqrsLevelListener);
        $this->bus->register($this->cqrsEventsLevelListener = new CqrsEventsLevelListener);

        $this->assertEquals(0, $this->cqrsLevelListener->getCallCount());
        $this->assertEquals(0, $this->cqrsEventsLevelListener->getCallCount());

        $this->bus->publish($this->createFakeEventOne());

        $this->assertEquals(1, $this->cqrsLevelListener->getCallCount());
        $this->assertEquals(1, $this->cqrsEventsLevelListener->getCallCount());

        $this->bus->publish($this->createDifferentEvent());

        $this->assertEquals(2, $this->cqrsLevelListener->getCallCount());
        $this->assertEquals(1, $this->cqrsEventsLevelListener->getCallCount());
    }

    private function createFakeEventOne()
    {
        return new FakeEventOne([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);
    }

    private function createFakeEventTwo()
    {
        return new FakeEventTwo([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);
    }

    private function createFakeEventThree()
    {
        return new FakeEventThree([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);
    }

    private function createDifferentEvent()
    {
        return new DifferentEvent([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);
    }
}
