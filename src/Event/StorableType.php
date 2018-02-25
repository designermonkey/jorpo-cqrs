<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Event;

use Ds\Hashable;

class StorableType implements Hashable
{
    /**
     * @var string
     */
    private $storable;

    /**
     * @param string $storable
     */
    public function __construct(string $storable)
    {
        $this->storable = $storable;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->asStorable();
    }

    /**
     * @return string
     */
    public function asStorable(): string
    {
        return str_replace('\\', '.', $this->storable);
    }

    /**
     * @return string
     */
    public function asNamespace(): string
    {
        return str_replace('.', '\\', $this->storable);
    }

    /**
     * @inheritDoc
     */
    public function hash(): string
    {
        return $this->__toString();
    }

    /**
     * @inheritDoc
     */
    public function equals($obj): bool
    {
        return $this->hash() === $obj->hash();
    }
}
