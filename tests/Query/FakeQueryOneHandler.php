<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

class FakeQueryOneHandler extends QueryHandler
{
    use QueryHandlerTestTrait;

    /**
     * @return array
     */
    public function handles(): array
    {
        return [FakeQueryOne::class];
    }

    public function handleFakeQueryOne()
    {
        $this->markHandled();
        $this->incrementCallCount();

        return [];
    }
}
