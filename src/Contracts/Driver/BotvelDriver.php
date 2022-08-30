<?php

namespace Thettler\Botvel\Contracts\Driver;

interface BotvelDriver
{
    public static function key(): string;

    public function commandConfig(): DriverCommandConfigInterface;
}
