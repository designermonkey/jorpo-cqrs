<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;

class CommandHandlerTest extends TestCase
{
    public function testShouldHandleCommand()
    {
        $subject = new CommandHandlerDummy;
        $subject->handle(new FakeCommand([]));
        $this->assertTrue($subject->wasHandled());
    }

    public function testShouldErrorWhenNoCommandMethodExists()
    {
        $this->expectException(BadMethodCallException::class);
        $subject = new CommandHandlerDummy;
        $subject->handle(new IgnoredCommand());
    }
}
