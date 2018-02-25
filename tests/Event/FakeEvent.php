<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class FakeEvent extends Event
{
    protected $badger;
    protected $mushroom;
}
