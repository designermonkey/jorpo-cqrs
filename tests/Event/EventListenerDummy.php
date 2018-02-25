<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class EventListenerDummy extends EventListener
{
    private $handled = false;

    /**
     * @return array
     */
    public function handles(): array
    {
        return [FakeEvent::class];
    }

    public function onFakeEvent(Event $event)
    {
        $this->handled = true;
    }

    public function wasHandled(): bool
    {
        return $this->handled;
    }
}
