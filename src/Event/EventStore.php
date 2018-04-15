<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use Jorpo\Cqrs\ObjectName;
use Jorpo\Cqrs\Event\Exception\ConcurrencyException;
use Jorpo\ValueObject\Identity\Uuid;

interface EventStore
{
    /**
     * @param ObjectName $type
     * @param Uuid $identity
     * @param iterable $events
     * @throws ConcurrencyException
     */
    public function storeEvents(ObjectName $type, Uuid $identity, iterable $events);

    /**
     * @param ObjectName $type
     * @param Uuid $identity
     * @return iterable
     * @throws IdentifierNotFoundException
     */
    public function getEvents(ObjectName $type, Uuid $identity): iterable;
}
