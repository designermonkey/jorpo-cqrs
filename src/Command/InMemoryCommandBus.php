<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command;

use RuntimeException;
use Ds\Map;
use Ds\Set;
use Jorpo\Cqrs\Command\Exception\CommandHandlerNotFoundException;

class InMemoryCommandBus implements CommandBus
{
    /**
     * @var Map
     */
    private $handlers;

    /**
     * @param Map $handlers
     */
    public function __construct()
    {
        $this->handlers = new Map;
    }

    /**
     * @param CommandHandler $handler
     */
    public function register(CommandHandler $handler): void
    {
        foreach ($handler->handles() as $messageType) {
            $handlers = $this->handlers->get($messageType, new Set);
            $handlers->add($handler);
            $this->handlers->put($messageType, $handlers);
        }
    }

    /**
     * @param Command $command
     * @throws CommandHandlerNotFoundException
     */
    public function dispatch(Command $command): void
    {
        $handlers = $this->handlers->get(get_class($command), new Set);

        if ($handlers->isEmpty()) {
            throw new CommandHandlerNotFoundException(sprintf(
                "Missing handler for command '%s'",
                get_class($command)
            ));
        }

        $handlers->first()->handle($command);
    }
}
