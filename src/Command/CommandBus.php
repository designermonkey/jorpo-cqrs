<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command;

use RuntimeException;

interface CommandBus
{
    /**
     * @param CommandHandler $handler
     */
    public function register(CommandHandler $handler): void;

    /**
     * @param Command $command
     * @throws RuntimeException
     */
    public function dispatch(Command $command): void;
}
