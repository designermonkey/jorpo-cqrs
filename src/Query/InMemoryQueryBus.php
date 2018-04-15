<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

use Ds\Map;
use Ds\Set;
use Jorpo\Cqrs\Query\Exception\QueryHandlerNotFoundException;

class InMemoryQueryBus implements QueryBus
{
    /**
     * @var Map
     */
    private $handlers;

    /**
     * @param Map $handlers
     */
    public function __construct()
    {
        $this->handlers = new Map;
    }

    /**
     * @param QueryHandler $handler
     */
    public function register(QueryHandler $handler): void
    {
        foreach ($handler->handles() as $messageType) {
            $handlers = $this->handlers->get($messageType, new Set);
            $handlers->add($handler);
            $this->handlers->put($messageType, $handlers);
        }
    }

    /**
     * @param Query $command
     * @throws RuntimeException
     * @return iterable
     */
    public function dispatch(Query $query): iterable
    {
        $handlers = $this->handlers->get(get_class($query), new Set);

        if ($handlers->isEmpty()) {
            throw new QueryHandlerNotFoundException(sprintf(
                "Missing handler for query '%s'",
                get_class($query)
            ));
        }

        return $handlers->first()->handle($query);
    }
}
