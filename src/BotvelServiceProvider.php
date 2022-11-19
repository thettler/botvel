<?php

namespace Thettler\Botvel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Thettler\Botvel\ArtisanCommands\BotvelCommand;

class BotvelServiceProvider extends PackageServiceProvider
{
    public function packageRegistered()
    {
        $this->app->singleton(BotvelRegistrar::class, fn() => new BotvelRegistrar());
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('botvel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_botvel_table')
            ->hasCommand(BotvelCommand::class);
    }
}
