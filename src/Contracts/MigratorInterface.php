<?php

namespace Thettler\Botvel\Contracts;

use Thettler\Botvel\Commands\Command;

interface MigratorInterface
{
    /**
     * @param  Command  ...$commands
     * @return Command[]
     */
    public function migrate(Command ...$commands): array;
}
