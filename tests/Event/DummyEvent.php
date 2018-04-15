<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class DummyEvent extends AbstractEvent
{
    protected $badger;
    protected $mushroom;
}
