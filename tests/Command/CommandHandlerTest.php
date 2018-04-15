<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Jorpo\Cqrs\Command\Exception\CommandHandlerNotFoundException;

class CommandHandlerTest extends TestCase
{
    public function testShouldHandleCommand()
    {
        $subject = new FakeCommandOneHandler;
        
        $subject->handle(new FakeCommandOne());
        $this->assertTrue($subject->wasHandled());
    }

    public function testShouldErrorWhenNoCommandMethodExists()
    {
        $this->expectException(CommandHandlerNotFoundException::class);
        $subject = new FakeCommandOneHandler;
        $subject->handle(new FakeCommandTwo());
    }
}
