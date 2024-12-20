<?php

namespace Eresendez\PackageSkeleton;

use Eresendez\PackageSkeleton\Console\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the service provider.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'package-skeleton');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'skeleton');

        $this->commands([
            InstallCommand::class,
        ]);

        $this->publishes([
            __DIR__.'/../config/skeleton.php' => config_path('package-skeleton.php'),
        ], 'package-config');

        $this->publishes([
            __DIR__.'/../resources/js' => resource_path('js/vendor/package-skeleton/js'),
        ], 'package-vue');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/package-skeleton'),
        ], 'package-views');

        $this->publishes([
            __DIR__.'/../dist' => public_path('vendor/package-skeleton'),
            __DIR__.'/../resources/assets' => public_path('vendor/package-skeleton/assets'),
        ], 'package-assets');
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        // Register the service here.
    }
}
