<?php

namespace Thettler\Botvel\Collections;

use Illuminate\Database\Eloquent\Collection;
use Thettler\Botvel\Models\MigratedCommand;

class MigratedCommandsCollection extends Collection
{
    public function filterByKey(string ...$keys): self
    {
        return $this->filter(
            fn (MigratedCommand $command) => in_array($command->key, $keys)
        );
    }

    public function filterByPlatform(string ...$platforms): self
    {
        return $this->first(
            fn (MigratedCommand $command) => in_array($command->plarform, $platforms)
        );
    }
}
