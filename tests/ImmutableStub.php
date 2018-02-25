<?php declare(strict_types=1);

namespace Jorpo\Cqrs;

class ImmutableStub extends Immutable
{
    private $hiddenProperty;
    protected $readOnlyProperty;
    public $accessibleProperty;

    public function __construct(iterable $properties = [])
    {
        parent::__construct(array_replace([
            'hiddenProperty' => 'mushroom',
            'readOnlyProperty' => 'badger',
            'accessibleProperty' => 'snaaake',
        ], $properties));
    }
}
