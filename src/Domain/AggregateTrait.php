<?php declare(strict_types=1);

namespace Jorpo\Support\Cqrs\EventSourced;

use BadMethodCallException;
use ReflectionClass;
use Traversable;
use Ds\Set;
use Jorpo\Support\Cqrs\Event\Event;
use Jorpo\Support\Cqrs\Event\EventSet;
use Jorpo\Support\Domain\EntityTrait;

trait AggregateRootTrait
{
    use EntityTrait;
    use VersionedTrait;

    /**
     * @var EventSet
     */
    private $events;

    /**
     * @return EventSet
     */
    public function getEvents(): EventSet
    {
        if (null === $this->events) {
            $this->events = new EventSet;
        }

        return $this->events;
    }

    public function clearEvents()
    {
        $this->getEvents()->clear();
    }

    /**
     * @param EventSet $history
     * @return AggregateRoot
     * @throws BadMethodCallException
     */
    public static function loadFromHistory(EventSet $history): AggregateRoot
    {
        $reflection = new ReflectionClass(get_called_class());
        $instance = $reflection->newInstanceWithoutConstructor();

        foreach ($history as $event) {
            $instance->applyChange($event);
            $instance->incrementVersion();
        }

        return $instance;
    }

    /**
     * @param Event $event
     * @throws BadMethodCallException
     */
    protected function applyEvent(Event $event)
    {
        $this->applyChange($event);
        $this->getEvents()->add($event);
        $this->incrementVersion();
        $event->version = $this->version();
    }

    /**
     * @param Event $event
     * @throws BadMethodCallException
     */
    protected function applyChange(Event $event)
    {
        $parts = explode('\\', get_class($event));
        $eventName = array_pop($parts);
        $actionMethod = AggregateRoot::HANDLER_PREFIX . ucfirst($eventName);

        if (!is_callable([$this, $actionMethod])) {
            throw new BadMethodCallException(sprintf(
                "Event handler method '%s::%s' does not exist.",
                get_class(),
                $actionMethod
            ));
        }

        $this->{$actionMethod}($event);
    }
}
