<?php

namespace Tests\Unit;

use Tests\TestCase;
use Eresendez\LaravelPackageSkeleton\SkeletonServiceProvider;

class SkeletonServiceProviderTest extends TestCase
{
    /**
     * Get package providers.
     */
    protected function getPackageProviders($app): array
    {
        return [
            SkeletonServiceProvider::class,
        ];
    }

    /** @test */
    public function it_loads_migrations()
    {
        $migrationPath = __DIR__.'/../../database/migrations';
        $this->assertDirectoryExists($migrationPath, 'Migration directory does not exist.');
    }

    /** @test */
    public function it_publishes_assets()
    {
        $this->artisan('vendor:publish', ['--tag' => 'skeleton-assets'])
            ->assertExitCode(0);

        $publishedPath = resource_path('js/vendor/skeleton');
        $this->assertDirectoryExists($publishedPath, 'Assets were not published correctly.');
    }
}
