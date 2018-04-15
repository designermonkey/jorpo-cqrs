<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command;

class FakeCommandOneHandler extends CommandHandler
{
    use CommandHandlerTestTrait;

    /**
     * @return array
     */
    public function handles(): array
    {
        return [FakeCommandOne::class];
    }

    public function handleFakeCommandOne()
    {
        $this->markHandled();
        $this->incrementCallCount();
    }
}
