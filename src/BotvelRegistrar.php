<?php

namespace Thettler\Botvel;

class BotvelRegistrar
{
    public function __construct(protected Botvel $botvel)
    {
    }

    public function registerCommands()
    {
        dd($this->botvel->getRegisteredCommands());
    }
}
