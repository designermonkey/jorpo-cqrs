<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class FakeEventOneListener extends EventListener
{
    use EventListenerTestTrait;

    public function handles(): array
    {
        return [FakeEventOne::class];
    }

    /**
     * @param FakeEvent $event
     */
    public function onFakeEventOne(): void
    {
        $this->markHandled();
        $this->incrementCallCount();
    }
}
