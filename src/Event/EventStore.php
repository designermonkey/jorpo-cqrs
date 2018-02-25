<?php declare(strict_types=1);

namespace Jorpo\Cqrs\EventStore;

use Jorpo\Cqrs\Event\Exception\ConcurrencyException;
use Jorpo\ValueObject\Identity\Uuid;

interface EventStore
{
    /**
     * @param StorableType $type
     * @param Uuid $identity
     * @param iterable $events
     * @throws ConcurrencyException
     */
    public function storeEvents(StorableType $type, Uuid $identity, iterable $events);

    /**
     * @param StorableType $type
     * @param Uuid $identity
     * @return iterable
     */
    public function getEvents(StorableType $type, Uuid $identity): iterable;
}
