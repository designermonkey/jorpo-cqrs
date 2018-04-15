<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    public function setUp()
    {
        $this->subject = new class([
            'badger' => 'mushroom',
            'mushroom' => 'badger',
        ]) extends Query
        {
            protected $badger;
            protected $mushroom;
        };
    }

    public function testShouldConstructWithProperties()
    {
        $this->assertTrue(isset($this->subject->badger));
        $this->assertTrue(isset($this->subject->mushroom));

        $this->assertSame('mushroom', $this->subject->badger);
        $this->assertSame('badger', $this->subject->mushroom);
    }

    public function testShouldHaveReadOnlyProperties()
    {
        $this->subject->badger = 'badger';
        $this->assertSame('mushroom', $this->subject->badger);

        unset($this->subject->mushroom);
        $this->assertSame('badger', $this->subject->mushroom);
    }
}
