<?php declare(strict_types=1);

namespace Jorpo\Cqrs;

use Jorpo\Cqrs\Event\Event;

class DifferentEvent extends Event
{
    protected $badger;
    protected $mushroom;
}
