<?php

namespace Thettler\Botvel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BotvelServiceProvider extends PackageServiceProvider
{
    public function packageRegistered()
    {
        $this->app->singleton(Botvel::class, fn () => new Botvel(new (config('botvel.store'))));
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
            ->hasMigration('create_botvel_table');
    }
}
