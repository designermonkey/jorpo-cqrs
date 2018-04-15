<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command\Exception;

use RuntimeException;

class CommandHandlerNotFoundException extends RuntimeException
{
}
