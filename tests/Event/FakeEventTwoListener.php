<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class FakeEventTwoListener extends EventListener
{
    use EventListenerTestTrait;

    public function handles(): array
    {
        return [FakeEventTwo::class];
    }

    public function onFakeEventTwo(): void
    {
        $this->markHandled();
        $this->incrementCallCount();
    }
}
