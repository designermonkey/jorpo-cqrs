<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event\Exception;

use RuntimeException;

class ConcurrencyException extends RuntimeException
{
}
