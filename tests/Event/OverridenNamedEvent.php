<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class OverridenNamedEvent extends Event
{
    protected $badger;
    protected $mushroom;

    public static function getName(): string
    {
        return 'overridden.name';
    }
}
