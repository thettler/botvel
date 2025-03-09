<?php

namespace Thettler\Botvel\Stores;

use Illuminate\Support\Collection;
use Thettler\Botvel\Contracts\StoreInterface;
use Thettler\Botvel\RegisteredBotvelCommand;

class MemoryStore implements StoreInterface
{
    public function __construct(protected Collection $commands = new Collection())
    {
    }


    public function all(): Collection
    {
        return $this->commands;
    }

    public function add(RegisteredBotvelCommand $command): bool
    {
        if ($command->getKey() === '') {
            $key = $this->createKey($command);
            $command->key($key);
        }

        $this->commands->put($command->getKey(), $command);
        return true;
    }

    public function findByName(string $name): RegisteredBotvelCommand|null
    {
        return $this->commands->first(fn(RegisteredBotvelCommand $command) => $command->getName() === $name);
    }

    public function createKey(RegisteredBotvelCommand $command): string
    {
        return base64_encode($command->getName());
    }

    public function find(string $key): RegisteredBotvelCommand|null
    {
        return $this->commands[$key] ?? null;
    }
}
