<?php

namespace Luna;

use Luna\Commands\LunaCommand;
use Luna\Commands\ModuleCommand;
use Luna\Module\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

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
            ->hasInertiaComponents()
            ->hasMigration('create_luna_panel_table')
            ->hasCommands([
                LunaCommand::class,
                ModuleCommand::class,
            ])->hasInstallCommand(function (InstallCommand $command) {
                $command
                    // ->publishConfigFile()
                    ->publishAssets();
                // ->publishMigrations()
                // ->askToRunMigrations()
                // ->copyAndRegisterServiceProviderInApp();
            });
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

    protected function bootPackageInertia(): self
    {
        if (!$this->package->hasInertiaComponents) {
            return $this;
        }

        $namespace = $this->package->viewNamespace;
        $directoryName = Str::of($this->packageView($namespace))->lower()->remove('-')->value();
        $vendorComponents = $this->package->basePath('/../resources/js');
        $appComponents = base_path("resources/js");

        if ($this->app->runningInConsole()) {
            $this->publishes(
                [$vendorComponents => $appComponents],
                "{$this->packageView($namespace)}-inertia-components"
            );
        }

        return $this;
    }
}
