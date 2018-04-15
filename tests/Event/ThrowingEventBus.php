<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use RuntimeException;

class ThrowingEventBus implements EventBus
{
    /**
     * @param EventListener $handler
     */
    public function register(EventListener $handler): void
    {
    }

    /**
     * @param Event $event
     */
    public function publish(Event $event): void
    {
        throw new RuntimeException;
    }
}
