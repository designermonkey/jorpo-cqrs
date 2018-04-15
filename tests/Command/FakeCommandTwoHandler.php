<?php declare(strict_types=1);

namespace Jorpo\Cqrs\Command;

class FakeCommandTwoHandler extends CommandHandler
{
    use CommandHandlerTestTrait;

    /**
     * @return array
     */
    public function handles(): array
    {
        return [FakeCommandTwo::class];
    }

    public function handleFakeCommandTwo()
    {
        $this->handled = true;
        $this->incrementCallCount();
    }
}
