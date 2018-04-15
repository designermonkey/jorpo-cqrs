<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use Jorpo\Cqrs\Immutable;
use Jorpo\ValueObject\Identity\Uuid;

abstract class AbstractEvent extends Immutable implements Event
{
    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var int
     */
    protected $version;

    /**
     * @param iterable $properties
     */
    public function __construct(iterable $properties = [])
    {
        $properties = is_array($properties) ? $properties : iterator_to_array($properties);

        $properties = array_replace([
            'uuid' => (string) Uuid::generate(),
            'timestamp' => microtime(true),
            'version' => 1,
        ], $properties);

        parent::__construct($properties);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return static::class;
    }
}
