<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

use Ds\Map;
use PHPUnit\Framework\TestCase;
use Jorpo\Cqrs\Query\Exception\QueryHandlerNotFoundException;

class InMemoryQueryBusTest extends TestCase
{
    public function setUp()
    {
        $this->bus = new InMemoryQueryBus;

        $this->handlerOne = new FakeQueryOneHandler;
        $this->handlerTwo = new FakeQueryTwoHandler;
    }

    public function testShouldRegisterHandlerAndDispatchQuery()
    {
        $this->bus->register($this->handlerOne);

        $this->assertEquals(0, $this->handlerOne->getCallCount());

        $this->bus->dispatch($query = $this->createFakeQueryOne());
        $this->bus->dispatch($query);
        $this->bus->dispatch($query);

        $this->assertEquals(3, $this->handlerOne->getCallCount());
    }

    public function testShouldOnlySendQueryToHandlerOfQuery()
    {
        $this->bus->register($this->handlerOne);
        $this->bus->register($this->handlerTwo);

        $this->assertEquals(0, $this->handlerOne->getCallCount());
        $this->assertEquals(0, $this->handlerTwo->getCallCount());

        $this->bus->dispatch($this->createFakeQueryOne());

        $this->assertEquals(1, $this->handlerOne->getCallCount());
        $this->assertEquals(0, $this->handlerTwo->getCallCount());

        $this->bus->dispatch($this->createFakeQueryTwo());

        $this->assertEquals(1, $this->handlerOne->getCallCount());
        $this->assertEquals(1, $this->handlerTwo->getCallCount());
    }

    public function testShouldErrorWhenNoHandlerRegisteredForQuery()
    {
        $this->expectException(QueryHandlerNotFoundException::class);

        $this->bus->dispatch($this->createFakeQueryOne());
    }

    private function createFakeQueryOne()
    {
        return new FakeQueryOne([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);
    }

    private function createFakeQueryTwo()
    {
        return new FakeQueryTwo([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);
    }

    private function createFakeQueryThree()
    {
        return new FakeQueryThree([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);
    }
}
