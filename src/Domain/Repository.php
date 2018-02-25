<?php declare(strict_types=1);

namespace Jorpo\Support\Cqrs\EventSourced;

use Jorpo\Support\Cqrs\EventSourced\Exception\AggregateNotFoundException;
use Jorpo\Support\Cqrs\EventSourced\Exception\ConcurrencyException;
use Jorpo\Support\ValueObject\Identity\Uuid;

interface AggregateRepository
{
    /**
     * @param AggregateRoot $aggregate
     * @throws ConcurrencyException
     */
    public function storeAggregate(AggregateRoot $aggregate);

    /**
     * @param Uuid $aggregateId
     * @return AggregateRoot
     * @throws AggregateNotFoundException
     */
    public function getAggregate(Uuid $aggregateId): AggregateRoot;
}
