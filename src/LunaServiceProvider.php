<?php

namespace Luna;

use Luna\Commands\LunaCommand;
use Luna\Commands\ModuleCommand;
use Luna\Module\Controller;
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
                ->as('luna.modules.' . $slug . '.')
                ->group(function () use ($moduleClass) {
                    Route::get('/', [Controller::class, 'index'])->defaults('module', $moduleClass)->name('index');
                    Route::get('/create', [Controller::class, 'create'])->defaults('module', $moduleClass)->name('create');
                    Route::post('/', [Controller::class, 'store'])->defaults('module', $moduleClass)->name('store');
                    Route::get('/{record}', [Controller::class, 'show'])->defaults('module', $moduleClass)->name('show');
                    Route::get('/{record}/edit', [Controller::class, 'edit'])->defaults('module', $moduleClass)->name('edit');
                    Route::match(['put', 'patch'], '/{record}', [Controller::class, 'update'])->defaults('module', $moduleClass)->name('update');
                    Route::delete('/{record}', [Controller::class, 'destroy'])->defaults('module', $moduleClass)->name('destroy');
                });
        });
    }
}
