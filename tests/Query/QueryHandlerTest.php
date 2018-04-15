<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Jorpo\Cqrs\Query\Exception\QueryHandlerNotFoundException;

class QueryHandlerTest extends TestCase
{
    public function testShouldHandleQuery()
    {
        $subject = new FakeQueryOneHandler;

        $result = $subject->handle(new FakeQueryOne());

        $this->assertTrue($subject->wasHandled());
        $this->assertSame([], $result);
    }

    public function testShouldErrorWhenNoQueryMethodExists()
    {
        $this->expectException(QueryHandlerNotFoundException::class);
        $subject = new FakeQueryOneHandler;
        $subject->handle(new FakeQueryTwo());
    }
}
