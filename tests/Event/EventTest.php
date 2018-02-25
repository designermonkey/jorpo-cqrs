<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testShouldConstructWithProperties()
    {
        $subject = new FakeEvent([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);

        $this->assertInstanceOf(Event::class, $subject);

        $this->assertTrue(isset($subject->badger));
        $this->assertTrue(isset($subject->mushroom));

        $this->assertSame('mushroom', $subject->badger);
        $this->assertSame('badger', $subject->mushroom);
    }

    public function testShouldHaveReadOnlyProperties()
    {
        $subject = new FakeEvent([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);

        $subject->badger = 'badger';
        $this->assertSame('mushroom', $subject->badger);

        unset($subject->mushroom);
        $this->assertSame('badger', $subject->mushroom);
    }
}
