<?php

namespace Thettler\Botvel\Contracts;

use Illuminate\Support\Collection;
use Thettler\Botvel\RegisteredBotvelCommand;

interface StoreInterface
{
    public function all(): Collection;

    public function add(RegisteredBotvelCommand $command): bool;

    public function createKey(RegisteredBotvelCommand $command): string;

    public function find(string $key): RegisteredBotvelCommand|null;

    public function findByName(string $name): RegisteredBotvelCommand|null;
}
