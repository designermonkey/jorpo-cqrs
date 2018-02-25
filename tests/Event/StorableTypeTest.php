<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use PHPUnit\Framework\TestCase;

class StorableTypeTest extends TestCase
{
    const NAMESPACE_STRING = 'Some\\PhpNamespace\\Here';
    const STORABLE_STRING = 'Some.PhpNamespace.Here';

    public function testShouldTakeNamespaceAndProduceStorableString()
    {
        $subject = new StorableType(self::NAMESPACE_STRING);

        $this->assertSame(self::STORABLE_STRING, (string) $subject);
        $this->assertSame(self::STORABLE_STRING, $subject->asStorable());
    }

    public function testShouldTakeStorableString()
    {
        $subject = new StorableType(self::STORABLE_STRING);

        $this->assertSame(self::STORABLE_STRING, (string) $subject);
        $this->assertSame(self::STORABLE_STRING, $subject->asStorable());
    }

    public function testShouldAlsoReturnNamespace()
    {
        $subject = new StorableType(self::NAMESPACE_STRING);
        $this->assertSame(self::NAMESPACE_STRING, $subject->asNamespace());

        $subject = new StorableType(self::STORABLE_STRING);
        $this->assertSame(self::NAMESPACE_STRING, $subject->asNamespace());
    }

    public function testShouldHash()
    {
        $subject = new StorableType(self::NAMESPACE_STRING);
        $this->assertSame(self::STORABLE_STRING, $subject->hash());
    }

    public function testShouldEnsureEquality()
    {
        $subjectOne = new StorableType(self::NAMESPACE_STRING);
        $subjectTwo = new StorableType(self::STORABLE_STRING);
        $subjectThree = new StorableType('Different');

        $this->assertTrue($subjectOne->equals($subjectTwo));
        $this->assertFalse($subjectOne->equals($subjectThree));
    }
}
