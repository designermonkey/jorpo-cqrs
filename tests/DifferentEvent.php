<?php declare(strict_types=1);

namespace Jorpo\Cqrs;

use Jorpo\Cqrs\Event\AbstractEvent;

class DifferentEvent extends AbstractEvent
{
    protected $badger;
    protected $mushroom;
}
