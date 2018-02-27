<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Domain;

use Jorpo\Cqrs\Domain\Exception\AggregateNotFoundException;
use Jorpo\Cqrs\Domain\Exception\ConcurrencyException;
use Jorpo\ValueObject\Identity\Uuid;

interface Repository
{
    /**
     * @return string
     */
    public function getAggregateType(): string;

    /**
     * @param AggregateRoot $aggregate
     * @return void
     * @throws ConcurrencyException
     */
    public function storeAggregate(AggregateRoot $aggregate): void;

    /**
     * @param Uuid $aggregateId
     * @return AggregateRoot
     * @throws AggregateNotFoundException
     */
    public function getAggregate(Uuid $aggregateId): AggregateRoot;
}
