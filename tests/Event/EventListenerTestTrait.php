<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

trait EventListenerTestTrait
{
    private $wasHandled = false;
    private $callCount = 0;

    public function handles(): array
    {
        return [];
    }

    public function markHandled()
    {
        $this->wasHandled = true;
    }

    public function wasHandled(): bool
    {
        return $this->wasHandled;
    }

    public function incrementCallCount()
    {
        $this->callCount ++;
    }

    public function getCallCount(): int
    {
        return $this->callCount;
    }
}
