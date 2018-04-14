<?php declare(strict_types=1);

namespace Jorpo\Cqrs;

use Ds\Hashable;

class ObjectName implements Hashable
{
    /**
     * @var string
     */
    private $objectName;

    /**
     * @param string $objectName
     */
    public function __construct(string $objectName)
    {
        $this->objectName = $objectName;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getDotSeparatedName();
    }

    /**
     * @return string
     */
    public function getDotSeparatedName(): string
    {
        return str_replace('\\', '.', $this->objectName);
    }

    /**
     * @return string
     */
    public function getObjectName(): string
    {
        return str_replace('.', '\\', $this->objectName);
    }

    /**
     * @return string
     */
    public function getObjectNamespace(): string
    {
        $parts = explode('\\', $this->getObjectName());
    
        if (1 === count($parts)) {
            return $parts[0];
        }
        
        array_pop($parts);
        
        return implode('\\', $parts);
    }

    /**
     * @return string
     */
    public function getDotSeparatedNamespace(): string
    {
        $parts = explode('.', $this->getDotSeparatedName());
    
        if (1 === count($parts)) {
            return $parts[0];
        }
        
        array_pop($parts);
        
        return implode('.', $parts);
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
