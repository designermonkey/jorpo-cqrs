<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class FakeEventOneTwoListener extends EventListener
{
    use EventListenerTestTrait;

    public function handles(): array
    {
        return [FakeEventOne::class, FakeEventTwo::class];
    }

    public function onFakeEventOne(): void
    {
        $this->markHandled();
        ++ $this->callCount;
    }

    public function onFakeEventTwo(): void
    {
        $this->markHandled();
        ++ $this->callCount;
    }
}
