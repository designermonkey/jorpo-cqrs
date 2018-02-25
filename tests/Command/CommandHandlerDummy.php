<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command;

class CommandHandlerDummy extends CommandHandler
{
    private $handled = false;

    /**
     * @return array
     */
    public function handles(): array
    {
        return [FakeCommand::class];
    }

    public function handleFakeCommand(Command $command)
    {
        $this->handled = true;
    }

    public function wasHandled(): bool
    {
        return $this->handled;
    }
}
