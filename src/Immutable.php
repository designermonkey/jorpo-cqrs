<?php declare(strict_types=1);

namespace Jorpo\Cqrs;

use ReflectionObject;
use ReflectionProperty;
use Ds\Hashable;

class Immutable implements Hashable
{
    /**
     * With an array of key => value pairs matching class properties, set them on the called class
     *
     * @param array $properties
     */
    public function __construct(iterable $properties = [])
    {
        foreach ($properties as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * No operation performed
     *
     * @param string $name
     * @param mixed $value
     */
    final public function __set(string $name, $value)
    {
    }

    /**
     * Test whether a property exists on the object
     *
     * @param string $name
     * @return bool
     */
    final public function __isset(string $name): bool
    {
        return array_key_exists($name, $this->toArray());
    }

    /**
     * Either get a property value, or null. Silences any PHP Notice errors.
     *
     * @param string $name
     * @return mixed
     */
    final public function __get(string $name)
    {
        return @$this->toArray()[$name] ?? null;
    }

    /**
     * @param string $name
     * @param array $args
     * @return mixed
     */
    final public function __call(string $name, array $args)
    {
        return $this->__get($name);
    }

    /**
     * No operation performed
     *
     * @param string $name
     */
    final public function __unset(string $name)
    {
    }

    /**
     * Converts to an array
     *
     * @return array
     */
    final public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * @inheritDoc
     */
    final public function hash(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * @inheritDoc
     */
    final public function equals($obj): bool
    {
        return $obj->hash() === $this->hash();
    }
}
