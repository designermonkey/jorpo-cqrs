<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use Jorpo\Cqrs\Event\Exception\EventHandlerNotFoundException;

abstract class EventListener
{
    const LISTENER_PREFIX = 'on';
    const CATCHALL_HANDLER = 'onAnyEvent';

    /**
     * @return array
     */
    abstract public function handles(): array;

    /**
     * @param Event $event
     * @throws EventHandlerNotFoundException
     */
    final public function handle(Event $event)
    {
        $handlerMethod = $this->getHandlerMethod($event);

        if (!method_exists($this, $handlerMethod)) {
            $handlerMethod = self::CATCHALL_HANDLER;

            if (!method_exists($this, $handlerMethod)) {
                throw new EventHandlerNotFoundException(sprintf(
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
