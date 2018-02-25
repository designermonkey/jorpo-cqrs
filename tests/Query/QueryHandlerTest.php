<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;

class QueryHandlerTest extends TestCase
{
    public function testShouldHandleQuery()
    {
        $subject = new QueryHandlerDummy;
        $result = $subject->handle(new FakeQuery([]));

        $this->assertTrue($subject->wasHandled());
        $this->assertSame([], $result);
    }

    public function testShouldErrorWhenNoQueryMethodExists()
    {
        $this->expectException(BadMethodCallException::class);
        $subject = new QueryHandlerDummy;
        $subject->handle(new IgnoredQuery());
    }
}
