<?php

namespace Thettler\Botvel\Fakes;

use Thettler\Botvel\Contracts\ConfiguratorInterface;
use Thettler\Botvel\Contracts\DriverWithMigrationInterface;
use Thettler\Botvel\Contracts\MigratorInterface;

class FakeDriver implements DriverWithMigrationInterface
{
    public static function key(): string
    {
        return 'fake';
    }

    public function migrator(): MigratorInterface
    {
        return new FakeMigrator();
    }

    public static function commandConfigurator(mixed ...$props): ConfiguratorInterface
    {
        return new FakeConfigurator();
    }
}
