<?php

namespace Luna;

use Luna\Commands\LunaCommand;
use Luna\Commands\ModuleCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->name('luna')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_luna_panel_table')
            ->hasCommands([
                LunaCommand::class,
                ModuleCommand::class,
            ]);
    }
}
