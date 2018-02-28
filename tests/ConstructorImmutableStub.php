<?php declare(strict_types=1);

namespace Jorpo\Cqrs;

class ConstructorImmutableStub extends Immutable
{
    private $hiddenProperty;
    protected $readOnlyProperty;
    public $accessibleProperty;

    public function __construct(string $hiddenProperty, string $readOnlyProperty, string $accessibleProperty)
    {
        $this->hiddenProperty = $hiddenProperty;
        $this->readOnlyProperty = $readOnlyProperty;
        $this->accessibleProperty = $accessibleProperty;
    }
}
