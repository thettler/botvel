<?php

namespace Thettler\Botvel\Drivers\NullDriver;

use Thettler\Botvel\Contracts\Driver\BotvelDriver;
use Thettler\Botvel\Contracts\Driver\DriverCommandConfigInterface;

class NullDriver implements BotvelDriver
{

    public static function key(): string
    {
        return 'null';
    }

    public function commandConfig(): DriverCommandConfigInterface
    {
        return new NullCommandConfig();
    }
}
