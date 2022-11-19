<?php

namespace Thettler\Botvel;

use Illuminate\Support\Collection;
use Thettler\Botvel\Commands\Command;

class BotvelRegistrar
{
    public function __construct(
        protected Collection $commands = new Collection()
    ) {
    }

    public function registerCommands()
    {

    }

    public function getCommands()
    {
        return $this->commands;
    }

    public function getCommand(string $identifier): Command|null
    {
        return $this->commands->first(fn(Command $command) => $command->identifier === $identifier);
    }

    public function addCommand(Command $command): static
    {
        $this->commands[] = $command;
        return $this;
    }
}
