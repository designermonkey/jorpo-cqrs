<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

class CqrsEventsLevelListener extends EventListener
{
    use EventListenerTestTrait;

    public function handles(): array
    {
        return ['Jorpo\\Cqrs\\Event\\'];
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

    public function onFakeEventThree(): void
    {
        $this->markHandled();
        ++ $this->callCount;
    }
}
