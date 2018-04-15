<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Domain\Event;

use Jorpo\Cqrs\Event\AbstractEvent;

class AggregateDummyCreated extends AbstractEvent
{
    protected $aggregateId;
    protected $value;
}
