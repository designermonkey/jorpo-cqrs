<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use BadMethodCallException;

abstract class EventListener
{
    const LISTENER_PREFIX = 'on';

    /**
     * @return array
     */
    abstract public function handles(): array;

    /**
     * @param Event $event
     * @throws BadMethodCallException
     */
    final public function handle(Event $event)
    {
        $handlerMethod = $this->getHandlerMethod($event);

        if (!method_exists($this, $handlerMethod)) {
            $handlerMethod = 'onEvent';

            if (!method_exists($this, $handlerMethod)) {
                throw new BadMethodCallException(sprintf(
                    "Event listener method '%s::%s' does not exist.",
                    get_called_class(),
                    $handlerMethod
                ));
            }
        }

        $this->{$handlerMethod}($event);
    }

    private function getHandlerMethod(Event $event): string
    {
        $parts = explode('\\', get_class($event));
        $eventName = array_pop($parts);
        return EventListener::LISTENER_PREFIX . ucfirst($eventName);
    }
}
