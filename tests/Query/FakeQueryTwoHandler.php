<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Query;

class FakeQueryTwoHandler extends QueryHandler
{
    use QueryHandlerTestTrait;

    /**
     * @return array
     */
    public function handles(): array
    {
        return [FakeQueryTwo::class];
    }

    public function handleFakeQueryTwo()
    {
        $this->markHandled();
        $this->incrementCallCount();

        return [];
    }
}
