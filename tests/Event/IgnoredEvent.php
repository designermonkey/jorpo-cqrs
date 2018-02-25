<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class IgnoredEvent extends Event
{
    protected $badger;
    protected $mushroom;
}
