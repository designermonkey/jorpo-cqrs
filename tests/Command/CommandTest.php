<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command;

use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    public function testShouldConstructWithProperties()
    {
        $subject = new FakeCommand([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);

        $this->assertInstanceOf(Command::class, $subject);

        $this->assertTrue(isset($subject->badger));
        $this->assertTrue(isset($subject->mushroom));

        $this->assertSame('mushroom', $subject->badger);
        $this->assertSame('badger', $subject->mushroom);
    }

    public function testShouldHaveReadOnlyProperties()
    {
        $subject = new FakeCommand([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]);

        $subject->badger = 'badger';
        $this->assertSame('mushroom', $subject->badger);

        unset($subject->mushroom);
        $this->assertSame('badger', $subject->mushroom);
    }
}
