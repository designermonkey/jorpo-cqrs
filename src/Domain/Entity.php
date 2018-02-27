<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Domain;

use Ds\Hashable;
use Jorpo\Cqrs\Immutable;
use Jorpo\ValueObject\Identity\Uuid;

abstract class Entity extends Immutable implements Hashable
{
    /**
     * @var Uuid
     */
    protected $identity;

    /**
     * @return Uuid
     */
    public function identity(): Uuid
    {
        return $this->identity;
    }

    /**
     * @inheritDoc
     */
    public function hash(): string
    {
        return (string) $this->identity();
    }

    /**
     * @inheritDoc
     */
    public function equals($obj): bool
    {
        return is_a($obj, get_called_class()) && $this->hash() === $obj->hash();
    }
}
