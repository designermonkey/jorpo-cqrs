<?php declare(strict_types=1);

namespace Jorpo\Cqrs;

use PHPUnit\Framework\TestCase;

class ImmutableTest extends TestCase
{
    public function testShouldAllowWriteAccessToPublicProperties()
    {
        $stub = new ImmutableStub;
        $this->assertSame('snaaake', $stub->accessibleProperty);

        $stub->accessibleProperty = 'badger';
        $this->assertSame('badger', $stub->accessibleProperty);
    }

    public function testShouldAllowReadOnlyAccessToProtectedProperties()
    {
        $stub = new ImmutableStub;
        $this->assertSame('badger', $stub->readOnlyProperty);

        $stub->accessibleProperty = 'mushroom';
        $this->assertSame('badger', $stub->readOnlyProperty);
    }

    public function testShouldNotAllowAccessToPrivateProperties()
    {
        $stub = new ImmutableStub;
        $this->assertNull($stub->hiddenProperty);
    }

    public function testShouldAllowCreationOfArray()
    {
        $stub = new ImmutableStub;
        $array = [
            'readOnlyProperty' => 'badger',
            'accessibleProperty' => 'snaaake',
        ];
        $this->assertSame($array, $stub->toArray());
    }

    public function testShouldHash()
    {
        $stub = new ImmutableStub;
        $array = [
            'readOnlyProperty' => 'badger',
            'accessibleProperty' => 'snaaake',
        ];
        $this->assertSame(json_encode($array), $stub->hash());
    }

    public function testShouldEnsureEquality()
    {
        $stubOne = new ImmutableStub;
        $stubTwo = new ImmutableStub;
        $stubThree = new ImmutableStub([
            'readOnlyProperty' => 'different',
        ]);

        $this->assertTrue($stubOne->equals($stubTwo));
        $this->assertFalse($stubOne->equals($stubThree));
    }
}
