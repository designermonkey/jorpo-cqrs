<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Domain\Event;

use Jorpo\Cqrs\Event\Event;

class AggregateDummyCreated extends Event
{
    protected $aggregateId;
    protected $value;
}
