<?php

namespace Thettler\Botvel\Fakes;

use Thettler\Botvel\Commands\Command;
use Thettler\Botvel\Contracts\MigratorInterface;

class FakeMigrator implements MigratorInterface
{
    public function migrate(Command ...$commands): array
    {
        return $commands;
    }
}
