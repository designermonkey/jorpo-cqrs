<?php declare(strict_types=1);

namespace Jorpo\Support\Cqrs\EventSourced;

use BadMethodCallException;
use Jorpo\Support\Cqrs\Event\EventSet;
use Jorpo\Support\Domain\Entity;

interface AggregateRoot extends Entity, Versioned
{
    /**
     * @var string
     */
    const HANDLER_PREFIX = 'on';

    /**
     * @return EventSet
     */
    public function getEvents(): EventSet;

    public function clearEvents();

    /**
     * @param EventSet $history
     * @return AggregateRoot
     * @throws BadMethodCallException
     */
    public static function loadFromHistory(EventSet $history): AggregateRoot;
}
