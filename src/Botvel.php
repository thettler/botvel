<?php

namespace Thettler\Botvel;

use Illuminate\Support\Collection;
use Thettler\Botvel\Contracts\StoreInterface;

class Botvel
{
    public function __construct(
        protected StoreInterface $store
    ) {}

    public function command(string $name, ?callable $commandCallback = null): RegisteredBotvelCommand
    {
        $registeredCommand = new RegisteredBotvelCommand(
            name: $name,
            bot: config('botvel.default_bot'),
        );

        if ($commandCallback) {
            $registeredCommand = $commandCallback($registeredCommand);
        }

        $this->store->add($registeredCommand);

        return $registeredCommand;
    }

    public function commands(): Collection
    {
        return $this->store->all();
    }

    public function store(): StoreInterface
    {
        return $this->store;
    }
}
