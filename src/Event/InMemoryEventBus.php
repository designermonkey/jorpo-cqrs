<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use Ds\Map;
use Ds\Set;

class InMemoryEventBus implements EventBus
{
    /**
     * @var Map
     */
    private $handlers;

    /**
     * @param Map $handlers
     */
    public function __construct()
    {
        $this->handlers = new Map;
    }

    /**
     * @param EventListener $handler
     */
    public function register(EventListener $handler): void
    {
        foreach ($handler->handles() as $messageType) {
            $handlers = $this->handlers->get($messageType, new Set);
            $handlers->add($handler);
            $this->handlers->put($messageType, $handlers);
        }
    }

    /**
     * @param Event $event
     */
    public function publish(Event $event): void
    {
        $handlers = $this->getHandlersForEvent(get_class($event));

        foreach ($handlers as $handler) {
            $handler->handle($event);
        }
    }


    private function getHandlersForEvent(string $messageType): Set
    {
        $handlerSets = $this->handlers->filter(function ($key) use ($messageType) {
            return 0 === strpos($messageType, $key);
        });

        $handlers = new Set;

        foreach ($handlerSets as $handlerSet) {
            $handlers = $handlers->union($handlerSet);
        }

        return $handlers;
    }
}
