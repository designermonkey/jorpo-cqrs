<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

class QueryHandlerDummy extends QueryHandler
{
    private $handled = false;

    /**
     * @return array
     */
    public function handles(): array
    {
        return [FakeQuery::class];
    }

    public function handleFakeQuery(Query $query)
    {
        $this->handled = true;

        return [];
    }

    public function wasHandled(): bool
    {
        return $this->handled;
    }
}
