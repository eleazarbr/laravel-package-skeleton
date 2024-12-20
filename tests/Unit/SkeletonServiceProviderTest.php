<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Eresendez\LaravelPackageSkeleton\SkeletonServiceProvider;
use Eresendez\LaravelPackageSkeleton\Seeders\SkeletonSeeder;

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

    protected function tearDown(): void
    {
        File::deleteDirectory(public_path('vendor/skeleton'));
        File::deleteDirectory(resource_path('views/vendor/skeleton'));
        File::deleteDirectory(resource_path('js/vendor/skeleton'));
        File::delete(config_path('skeleton.php'));

        parent::tearDown();
    }

    /** @test */
    public function it_loads_migrations()
    {
        $migrationPath = database_path('migrations');
        $this->artisan('migrate')->assertExitCode(0);

        $this->assertDirectoryExists($migrationPath, 'Migration directory does not exist.');
    }

    /** @test */
    public function it_runs_the_skeleton_seeder()
    {
        $this->seed(SkeletonSeeder::class);
        $this->assertTrue(true);
    }

    /** @test */
    public function it_publishes_assets()
    {
        $this->artisan('vendor:publish', ['--tag' => 'skeleton-assets'])
            ->assertExitCode(0);

        $publishedPath = public_path('vendor/skeleton/assets');
        $this->assertDirectoryExists($publishedPath, 'Assets were not published correctly.');
    }

    /** @test */
    public function it_publishes_views()
    {
        $this->artisan('vendor:publish', ['--tag' => 'skeleton-views'])
            ->assertExitCode(0);

        $publishedPath = resource_path('views/vendor/skeleton');
        $this->assertDirectoryExists($publishedPath, 'Views were not published correctly.');
    }

    /** @test */
    public function it_publishes_vue_components()
    {
        $this->artisan('vendor:publish', ['--tag' => 'skeleton-vue'])
            ->assertExitCode(0);

        $publishedPath = resource_path('js/vendor/skeleton');
        $this->assertDirectoryExists($publishedPath, 'Vue components were not published correctly.');
    }

    /** @test */
    public function it_publishes_config_file()
    {
        $this->artisan('vendor:publish', ['--tag' => 'skeleton-config'])
            ->assertExitCode(0);

        $configPath = config_path('skeleton.php');
        $this->assertFileExists($configPath, 'Config file was not published correctly.');
    }

    /** @test */
    public function it_loads_routes()
    {
        $response = $this->get('/skeleton');
        $response->assertStatus(200);
        $response->assertSee('Skeleton Route');

        $response = $this->getJson('/api/1.0/skeleton-api');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Skeleton API']);
    }

    /** @test */
    public function it_loads_translations()
    {
        $translation = __('skeleton::messages.welcome');
        $this->assertEquals('Welcome to Skeleton!', $translation, 'English translation failed.');

        app()->setLocale('es');
        $translation = __('skeleton::messages.welcome');
        $this->assertEquals('¡Bienvenido a Skeleton!', $translation, 'Spanish translation failed.');
    }
}
