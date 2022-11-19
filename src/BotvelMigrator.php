<?php

namespace Thettler\Botvel;

use Illuminate\Support\Arr;
use Thettler\Botvel\Commands\Command;
use Thettler\Botvel\Contracts\DriverWithMigrationInterface;
use Thettler\Botvel\Contracts\MigratorInterface;

class BotvelMigrator
{
    protected array $migratedCommands = [];

    public function __construct(
        protected BotvelRegistrar $registrar
    ) {
    }

    public function migratedCommands(): array
    {
        return $this->migratedCommands;
    }

    public function migrate()
    {
        $drivers = collect(\Thettler\Botvel\Facades\Botvel::drivers())
            ->filter(fn(string $diver) => in_array(DriverWithMigrationInterface::class, class_implements($diver)))
            ->map(fn(string $diver) => app($diver));

        if ($drivers->isEmpty()) {
            return;
        }

        $drivers->each(function (DriverWithMigrationInterface $driver) {
            $migratedCommands = $driver->migrator()
                ->migrate(...$this->registrar->getCommands());

            $this->migratedCommands[$driver::key()] = $migratedCommands;
        });
    }

    public function isCommandMigrated(string $identifier, string $drivers): bool
    {
        $migratedCommands = $this->migratedCommands[$drivers] ?? false;

        if (!$migratedCommands) {
            return false;
        }

        $commands = array_filter($migratedCommands, fn(Command $command) => $command->identifier === $identifier);

        if (empty($commands)) {
            return false;
        }

        return true;
    }
}
