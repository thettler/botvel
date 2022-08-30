<?php

namespace Thettler\Botvel\Contracts\Driver;

use Thettler\Botvel\BotvelCommand;

interface BotvelRegistrarDriverInterface
{
    public function onCreate(BotvelCommand $command): void;

    public function onUpdate(BotvelCommand $command): void;

    public function onDelete(BotvelCommand $command): void;

    public function after(): void;

    public function before(): void;
}
