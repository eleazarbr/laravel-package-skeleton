<?php

namespace Eresendez\LaravelPackageSkeleton;

use Illuminate\Support\ServiceProvider;

class SkeletonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the service provider.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'skeleton');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->publishes([
            __DIR__.'/../config/skeleton.php' => config_path('skeleton.php'),
        ], 'skeleton-config');

        $this->publishes([
            __DIR__.'/../resources/js' => resource_path('js/vendor/skeleton/js'),
        ], 'skeleton-vue');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/skeleton/views'),
        ], 'skeleton-views');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/skeleton/assets'),
        ], 'skeleton-assets');
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        // Register the service here.
    }
}
