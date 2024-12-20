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

        $this->publishes([
            __DIR__.'/../resources/js' => resource_path('js/vendor/skeleton'),
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
