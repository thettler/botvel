<?php

namespace Thettler\Botvel;

use Illuminate\Foundation\Application;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Thettler\Botvel\Commands\BotvelCommand;
use Thettler\Botvel\Factories\BotvelCommandFactory;

class BotvelServiceProvider extends PackageServiceProvider
{
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
            ->hasMigration('create_botvel_table');
//            ->hasCommand(BotvelCommand::class);
    }

    public function packageRegistered()
    {
        $this->app->singleton(Botvel::class, fn(Application $app) => new Botvel());
        $this->app->singleton(BotvelRegistrar::class,
            fn(Application $app) => new BotvelRegistrar($app->make(Botvel::class)));
        $this->app->bind(BotvelCommandFactory::class, fn() => new BotvelCommandFactory());
    }
}
