<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Domain;

use BadMethodCallException;
use ReflectionClass;
use Ds\Sequence;
use Ds\Vector;
use Jorpo\Cqrs\Event\Event;
use Jorpo\ValueObject\Identity\Uuid;

class AggregateRoot
{
    /**
     * @var string
     */
    const HANDLER_PREFIX = 'handle';

    /**
     * @var Uuid
     */
    protected $identity;

    /**
     * @var int
     */
    protected $version = 0;

    /**
     * @var Sequence
     */
    protected $uncomittedEvents;

    /**
     * @return Uuid
     */
    public function identity(): Uuid
    {
        return $this->identity;
    }

    /**
     * @return integer
     */
    public function version(): int
    {
        return $this->version;
    }

    /**
     * @return boolean
     */
    public function hasUncomittedEvents(): bool
    {
        $this->ensureUncomittedEvents();

        return !$this->uncomittedEvents->isEmpty();
    }

    /**
     * @return Sequence
     */
    public function getUncomittedEvents(): Sequence
    {
        $this->ensureUncomittedEvents();

        return $this->uncomittedEvents;
    }

    /**
     * @param iterable $history
     * @return AggregateRoot
     * @throws BadMethodCallException
     */
    public static function loadFromHistory(iterable $history): AggregateRoot
    {
        $reflection = new ReflectionClass(get_called_class());
        $instance = $reflection->newInstanceWithoutConstructor();

        foreach ($history as $event) {
            $instance->applyChange($event);
            $instance->version = $event->version;
        }

        return $instance;
    }

    /**
     * @return integer
     */
    protected function getNextVersion(): int
    {
        return $this->version + 1;
    }

    /**
     * @param Event $event
     * @throws BadMethodCallException
     */
    protected function applyEvent(Event $event)
    {
        $this->version = $event->version;
        $this->applyChange($event);
        ($this->getUncomittedEvents())->push($event);
    }

    /**
     * @param Event $event
     * @throws BadMethodCallException
     */
    protected function applyChange(Event $event)
    {
        $handlerMethod = $this->getHandlerMethod($event);

        if (!method_exists($this, $handlerMethod)) {
            throw new BadMethodCallException(sprintf(
                "Event handler method '%s::%s' does not exist.",
                get_class(),
                $handlerMethod
            ));
        }

        $this->{$handlerMethod}($event);
    }

    private function getHandlerMethod(Event $event): string
    {
        $parts = explode('\\', get_class($event));
        $eventName = array_pop($parts);
        return AggregateRoot::HANDLER_PREFIX . ucfirst($eventName);
    }

    private function ensureUncomittedEvents()
    {
        $this->uncomittedEvents = $this->uncomittedEvents ?? new Vector;
    }
}
