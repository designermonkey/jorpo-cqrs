<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Domain;

use Jorpo\Cqrs\Domain\Event\AggregateDummyCreated;
use Jorpo\Cqrs\Domain\Event\AggregateValueChanged;
use Jorpo\ValueObject\Identity\Uuid;

class AggregateRootDummy extends AggregateRoot
{
    public $value;

    public function __construct(Uuid $identity, string $value)
    {
        $this->applyEvent(new AggregateDummyCreated([
            'aggregateId' => (string) $identity,
            'value' => $value,
            'version' => $this->getNextVersion(),
        ]));
    }

    public function changeValue(string $value)
    {
        $this->applyEvent(new AggregateValueChanged([
            'aggregateId' => (string) $this->identity(),
            'value' => $value,
            'version' => $this->getNextVersion(),
        ]));
    }


    protected function handleAggregateDummyCreated(AggregateDummyCreated $event)
    {
        $this->identity = Uuid::fromString($event->aggregateId);
        $this->value = $event->value;
    }

    protected function handleAggregateValueChanged(AggregateValueChanged $event)
    {
        $this->value = $event->value;
    }
}
