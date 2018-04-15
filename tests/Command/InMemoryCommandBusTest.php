<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command;

use RuntimeException;
use Ds\Map;
use PHPUnit\Framework\TestCase;
use Jorpo\Cqrs\Command\Exception\CommandHandlerNotFoundException;

class InMemoryCommandBusTest extends TestCase
{
    public function setUp()
    {
        $this->bus = new InMemoryCommandBus;

        $this->handlerOne = new FakeCommandOneHandler;
        $this->handlerTwo = new FakeCommandTwoHandler;
    }

    public function testShouldRegisterHandlerAndDispatchCommand()
    {
        $this->bus->register($this->handlerOne);

        $this->assertEquals(0, $this->handlerOne->getCallCount());

        $this->bus->dispatch($command = $this->createFakeCommandOne());
        $this->bus->dispatch($command);
        $this->bus->dispatch($command);

        $this->assertEquals(3, $this->handlerOne->getCallCount());
    }

    public function testShouldOnlySendCommandToHandlerOfCommand()
    {
        $this->bus->register($this->handlerOne);
        $this->bus->register($this->handlerTwo);

        $this->assertEquals(0, $this->handlerOne->getCallCount());
        $this->assertEquals(0, $this->handlerTwo->getCallCount());

        $this->bus->dispatch($this->createFakeCommandOne());

        $this->assertEquals(1, $this->handlerOne->getCallCount());
        $this->assertEquals(0, $this->handlerTwo->getCallCount());

        $this->bus->dispatch($this->createFakeCommandTwo());

        $this->assertEquals(1, $this->handlerOne->getCallCount());
        $this->assertEquals(1, $this->handlerTwo->getCallCount());
    }

    public function testShouldErrorWhenNoHandlerRegisteredForCommand()
    {
        $this->expectException(CommandHandlerNotFoundException::class);

        $this->bus->dispatch($this->createFakeCommandThree());
    }

    private function createFakeCommandOne()
    {
        return new FakeCommandOne([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);
    }

    private function createFakeCommandTwo()
    {
        return new FakeCommandTwo([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);
    }

    private function createFakeCommandThree()
    {
        return new FakeCommandThree([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);
    }
}
