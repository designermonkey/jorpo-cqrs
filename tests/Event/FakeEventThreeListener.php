<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class FakeEventThreeListener extends EventListener
{
    use EventListenerTestTrait;

    public function handles(): array
    {
        return [FakeEventThree::class];
    }

    public function onFakeEventThree(): void
    {
        $this->markHandled();
        ++ $this->callCount;
    }
}
