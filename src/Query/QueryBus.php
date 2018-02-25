<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

use RuntimeException;

interface QueryBus
{
    /**
     * @param QueryHandler $handler
     */
    public function register(QueryHandler $handler): void;

    /**
     * @param Query $query
     * @return iterable
     * @throws RuntimeException
     */
    public function dispatch(Query $query): iterable;
}
