<?php declare(strict_types=1);

namespace Jorpo\Cqrs;

use PHPUnit\Framework\TestCase;

class ObjectNameTest extends TestCase
{
    const OBJECT_NAME_STRING = 'Some\\NameSpace\\Object';
    const OBJECT_NAMESPACE_STRING = 'Some\\NameSpace';
    const DOT_SEPARATED_NAME_STRING = 'Some.NameSpace.Object';
    const DOT_SEPARATED_NAMESPACE_STRING = 'Some.NameSpace';

    public function testShouldTakeObjectNameAndReturnObjectName()
    {
        $subject = new ObjectName(self::OBJECT_NAME_STRING);
        $this->assertSame(self::OBJECT_NAME_STRING, $subject->getObjectName());
    }

    public function testShouldTakeObjectNameAndProduceDotSeparatedName()
    {
        $subject = new ObjectName(self::OBJECT_NAME_STRING);

        $this->assertSame(self::DOT_SEPARATED_NAME_STRING, (string) $subject);
        $this->assertSame(self::DOT_SEPARATED_NAME_STRING, $subject->getDotSeparatedName());
    }

    public function testShouldTakeObjectNameAndProduceObjectNamespace()
    {
        $subject = new ObjectName(self::OBJECT_NAME_STRING);

        $this->assertSame(self::DOT_SEPARATED_NAME_STRING, (string) $subject);
        $this->assertSame(self::OBJECT_NAMESPACE_STRING, $subject->getObjectNamespace());
    }

    public function testShouldTakeObjectNameAndProduceDotSeparatedNamespace()
    {
        $subject = new ObjectName(self::OBJECT_NAME_STRING);

        $this->assertSame(self::DOT_SEPARATED_NAME_STRING, (string) $subject);
        $this->assertSame(self::DOT_SEPARATED_NAMESPACE_STRING, $subject->getDotSeparatedNamespace());
    }

    public function testShouldTakeDotSeparatedNameAndProduceDotSeparatedName()
    {
        $subject = new ObjectName(self::DOT_SEPARATED_NAME_STRING);

        $this->assertSame(self::DOT_SEPARATED_NAME_STRING, (string) $subject);
        $this->assertSame(self::DOT_SEPARATED_NAME_STRING, $subject->getDotSeparatedName());
    }

    public function testShouldTakeDotSeparatedNameAndReturnObjectName()
    {
        $subject = new ObjectName(self::DOT_SEPARATED_NAME_STRING);
        $this->assertSame(self::OBJECT_NAME_STRING, $subject->getObjectName());
    }

    public function testShouldTakeDotSeparatedNameAndReturnObjectNamespace()
    {
        $subject = new ObjectName(self::DOT_SEPARATED_NAME_STRING);
        $this->assertSame(self::OBJECT_NAMESPACE_STRING, $subject->getObjectNamespace());
    }

    public function testShouldTakeDotSeparatedNameAndReturnDotSeparatedNamespace()
    {
        $subject = new ObjectName(self::DOT_SEPARATED_NAME_STRING);
        $this->assertSame(self::DOT_SEPARATED_NAMESPACE_STRING, $subject->getDotSeparatedNamespace());
    }

    public function testShouldHash()
    {
        $subject = new ObjectName(self::OBJECT_NAME_STRING);
        $this->assertSame(self::DOT_SEPARATED_NAME_STRING, $subject->hash());
    }

    public function testShouldEnsureEquality()
    {
        $subjectOne = new ObjectName(self::OBJECT_NAME_STRING);
        $subjectTwo = new ObjectName(self::DOT_SEPARATED_NAME_STRING);
        $subjectThree = new ObjectName('Different');

        $this->assertTrue($subjectOne->equals($subjectTwo));
        $this->assertFalse($subjectOne->equals($subjectThree));
    }
}
