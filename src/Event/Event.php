<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

interface Event
{
    /**
     * @return string
     */
    public static function getName(): string;
}
