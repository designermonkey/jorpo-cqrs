<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use Jorpo\Cqrs\Immutable;
use Jorpo\ValueObject\Identity\Uuid;

abstract class Event extends Immutable
{
    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $id;

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
            'id' => (string) Uuid::generate(),
            'timeatamp' => microtime(true),
            'version' => 0,
        ], $properties);

        parent::__construct($properties);
    }
}
