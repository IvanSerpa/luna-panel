<?php

namespace Luna;

use Luna\Commands\LunaCommand;
use Luna\Commands\ModuleCommand;
use Illuminate\Support\Facades\Route;
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

    public function packageRegistered(): void
    {
        // Bind the core Luna object so the facade works.
        $this->app->singleton(\Luna\Luna::class, fn() => new \Luna\Luna());
    }

    public function packageBooted(): void
    {
        $this->registerModuleRoutes();
    }

    protected function registerModuleRoutes(): void
    {
        $luna = $this->app->make(\Luna\Luna::class);

        $luna->modules()->each(function (string $moduleClass) {
            $slug = $moduleClass::slug();

            Route::middleware(['web'])
                ->prefix($slug)
                ->name('luna.modules.' . $slug . '.')
                ->group(function () use ($moduleClass) {
                    Route::get('/', function () use ($moduleClass) {
                        return response()->json([
                            'module' => $moduleClass,
                        ]);
                    })->name('index');
                });
        });
    }
}
