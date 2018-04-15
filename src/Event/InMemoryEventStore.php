<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use Ds\Map;
use Ds\Set;
use Ds\Vector;
use Jorpo\Cqrs\ObjectName;
use Jorpo\Cqrs\Event\Exception\ConcurrencyException;
use Jorpo\Cqrs\Event\Exception\IdentifierNotFoundException;
use Jorpo\ValueObject\Identity\Uuid;

class InMemoryEventStore implements EventStore
{
    /**
     * @var EventBus
     */
    private $bus;

    /**
     * @var Map
     */
    private $store;

    /**
     * @param Map $store
     */
    public function __construct(EventBus $bus)
    {
        $this->bus = $bus;
        $this->store = new Map;
    }

    /**
     * @inheritDoc
     */
    public function storeEvents(ObjectName $type, Uuid $identity, iterable $events)
    {
        if (!$this->store->hasKey($type)) {
            $this->store->put($type, new Map);

            if (!$this->store->get($type)->hasKey($identity)) {
                $this->store->get($type)->put($identity, new Vector);
            }
        }

        $store = $this->store->get($type)->get($identity);
        $expectedVersion = 0;

        if (count($store) !== 0) {
            $event = $store->toArray();
            $event = array_pop($event);
            $expectedVersion = $event->version;
        }

        foreach ($events as $event) {
            if ($store->contains($event)) {
                continue;
            }

            if ($event->version !== ++$expectedVersion) {
                throw new ConcurrencyException("Event version does not match expected version.");
            }

            $this->bus->publish($event);
            $store->insert($event->version - 1, $event);
        }
    }

    /**
     * @inheritDoc
     */
    public function getEvents(ObjectName $type, Uuid $identity): iterable
    {
        $this->testIdentifierIsFound($type, $identity);
        return $this->store->get($type, new Map)->get($identity);
    }

    private function testIdentifierIsFound(ObjectName $type, Uuid $identity)
    {
        if (!$this->store->hasKey($type) || !$this->store->get($type)->hasKey($identity) || $this->store->get($type)->get($identity)->isEmpty()) {
            throw new IdentifierNotFoundException(sprintf(
                "The identity '%s' was not found for the type '%s'",
                (string) $identity,
                (string) $type
            ));
        }
    }
}
