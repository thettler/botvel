<?php

namespace Thettler\Botvel\Contracts;

interface DriverWithMigrationInterface extends DriverInterface
{
    public function migrator(): MigratorInterface|null;
}
