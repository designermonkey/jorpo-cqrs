<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

use Jorpo\Cqrs\Query\Exception\QueryHandlerNotFoundException;

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
     * @throws QueryHandlerNotFoundException
     */
    public function handle(Query $query): iterable
    {
        $handlerMethod = $this->getHandlerMethod($query);

        if (!method_exists($this, $handlerMethod)) {
            throw new QueryHandlerNotFoundException(sprintf(
                "Query handler method '%s::%s' does not exist.",
                get_called_class(),
                $handlerMethod
            ));
        }

        return $this->{$handlerMethod}($query);
    }

    private function getHandlerMethod(Query $query): string
    {
        $parts = explode('\\', get_class($query));
        $queryName = array_pop($parts);
        return QueryHandler::HANDLER_PREFIX . ucfirst($queryName);
    }
}
