<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

use BadMethodCallException;

abstract class QueryHandler
{
    const HANDLER_PREFIX = 'handle';

    /**
     * @return array
     */
    abstract public function handles(): array;

    /**
     * @param Query $query
     * @return iterable
     * @throws BadMethodCallException
     */
    public function handle(Query $query): iterable
    {
        $parts = explode('\\', get_class($query));
        $queryName = array_pop($parts);
        $handlerMethod = QueryHandler::HANDLER_PREFIX . ucfirst($queryName);

        if (!method_exists($this, $handlerMethod)) {
            throw new BadMethodCallException(sprintf(
                "Query handler method '%s::%s' does not exist.",
                get_called_class(),
                $handlerMethod
            ));
        }

        return $this->{$handlerMethod}($query);
    }
}