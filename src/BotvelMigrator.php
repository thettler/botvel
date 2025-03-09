<?php

namespace Thettler\Botvel;

use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Thettler\Botvel\Collections\MigratedCommandsCollection;
use Thettler\Botvel\Models\MigratedCommand;

class BotvelMigrator
{

    protected MigratedCommandsCollection $alreadyMigrated;

    /**
     * @param  Collection<RegisteredBotvelCommand>  $commands
     */
    public function __construct(protected Collection $commands)
    {
    }

    public static function commands(RegisteredBotvelCommand ...$commands): self
    {
        return new self(collect($commands));
    }

    /**
     * @param  string[]  $keys
     * @return MigratedCommandsCollection
     */
    public function getMigratedCommands(array $keys = []): MigratedCommandsCollection
    {
        return MigratedCommand::query()
            ->when(!empty($keys), fn(Builder $builder) => $builder->whereIn('key', $keys))
            ->get();
    }

    public function migrate()
    {
        $this->fetchAlreadyMigrate();

        $this->commands
            ->filter([$this, 'dirtyCheckCommand'])
            ->each([$this, 'migrateCommand']);
    }

    protected function migrateCommand(RegisteredBotvelCommand $registeredBotvelCommand)
    {
        $bot = $registeredBotvelCommand->getBot();
        $platforms = config('botvel.bots.'.$bot.'.platforms');

        foreach ($platforms as $platform) {
            $alreadyMigrated = $this->getCommandMigrations($registeredBotvelCommand, $platform);

            if ($alreadyMigrated) {
                return $this->updateMigration($alreadyMigrated, $registeredBotvelCommand);
            }

            return $this->createMigration($registeredBotvelCommand, $platform);
        }


    }

    protected function createMigration(
        RegisteredBotvelCommand $registeredBotvelCommand,
    ): MigratedCommand {

       // todo: Call Provider Driver
        $platformsConfig = [
            'discord' => [
                'scopes' => [
                    '__global__' => 'globalId',
                    'guildId' => 'guildId',
                ],
                'fingerprint' => $registeredBotvelCommand->getFingerprint('discord'),
            ]
        ];

        MigratedCommand::create([
            'key' => $registeredBotvelCommand->getKey(),
            'bot' => $registeredBotvelCommand->getBot(),
            'platforms' => $platformsConfig,
            'migrated_at' => now(),
        ]);
    }

    protected function updateMigration(
        MigratedCommand $migratedCommand,
        RegisteredBotvelCommand $registeredBotvelCommand
    ): MigratedCommand {

    }

    protected function dirtyCheckCommand(RegisteredBotvelCommand $registeredBotvelCommand): bool
    {
        if ($this->alreadyMigrated->isEmpty()) {
            return true;
        }

        return !!$this->alreadyMigrated
            ->first(
                fn(MigratedCommand $migratedCommand
                ) => $migratedCommand->fingerprint !== $registeredBotvelCommand->getFingerprint($migratedCommand->platform)
            );
    }

    protected function fetchAlreadyMigrate(): void
    {
        $commandKeys = $this->commands
            ->map(fn(RegisteredBotvelCommand $registeredBotvelCommand) => $registeredBotvelCommand->getKey())
            ->toArray();

        $this->alreadyMigrated = $this->getMigratedCommands($commandKeys);
    }

    protected function getCommandMigrations(
        RegisteredBotvelCommand $registeredBotvelCommand,
        string $platform
    ): MigratedCommandsCollection {
        return $this->alreadyMigrated
            ->filterByPlatform($platform)
            ->filterByKey($registeredBotvelCommand->getKey());
    }
}
