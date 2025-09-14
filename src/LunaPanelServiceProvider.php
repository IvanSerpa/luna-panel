<?php

namespace LunaPanel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use LunaPanel\Commands\LunaPanelCommand;

class LunaPanelServiceProvider extends PackageServiceProvider
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
            ->hasCommand(LunaPanelCommand::class);
    }
}
