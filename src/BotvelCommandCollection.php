<?php

namespace Thettler\Botvel;

use Illuminate\Support\Collection;

/**
 * @extends Collection<int, BotvelCommand>
 */
class BotvelCommandCollection extends Collection
{
    public function keyExist(string $key): bool
    {
        return ! ! $this->first(fn (BotvelCommand $command) => $command->key === $key);
    }
}
