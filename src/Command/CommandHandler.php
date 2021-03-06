<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command;

use BadMethodCallException;
use Jorpo\Cqrs\Command\Exception\CommandHandlerNotFoundException;

abstract class CommandHandler
{
    const HANDLER_PREFIX = 'handle';

    /**
     * @return array
     */
    abstract public function handles(): array;

    /**
     * @param Command $command
     * @throws CommandHandlerNotFoundException
     */
    final public function handle(Command $command): void
    {
        $handlerMethod = $this->getHandlerMethod($command);

        if (!method_exists($this, $handlerMethod)) {
            throw new CommandHandlerNotFoundException(sprintf(
                "Command handler method '%s::%s' does not exist.",
                get_called_class(),
                $handlerMethod
            ));
        }

        $this->{$handlerMethod}($command);
    }

    private function getHandlerMethod(Command $command): string
    {
        $parts = explode('\\', get_class($command));
        $commandName = array_pop($parts);
        return CommandHandler::HANDLER_PREFIX . ucfirst($commandName);
    }
}
