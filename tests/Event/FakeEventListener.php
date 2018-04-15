<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class FakeEventListener extends EventListener
{
    use EventListenerTestTrait;

    /**
     * @return array
     */
    public function handles(): array
    {
        return [FakeEvent::class];
    }

    public function onFakeEvent(Event $event)
    {
        $this->markHandled();
    }
}
