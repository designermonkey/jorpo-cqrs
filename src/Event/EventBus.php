<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use RuntimeException;

interface EventBus
{
    /**
     * @param EventListener $handler
     */
    public function register(EventListener $handler): void;

    /**
     * @param Event $event
     * @throws RuntimeException
     */
    public function publish(Event $event): void;
}
