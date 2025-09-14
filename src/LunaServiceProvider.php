<?php

namespace Luna;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Luna\Commands\LunaCommand;

class LunaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('luna-panel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_luna_panel_table')
            ->hasCommand(LunaCommand::class);
    }
}
