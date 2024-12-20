<?php

namespace Tests\Unit;

use Eresendez\LaravelPackageSkeleton\Seeders\SkeletonSeeder;
use Eresendez\LaravelPackageSkeleton\SkeletonServiceProvider;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

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

    public function testItLoadsMigrations()
    {
        $migrationPath = database_path('migrations');
        $this->artisan('migrate')->assertExitCode(0);

        $this->assertDirectoryExists($migrationPath, 'Migration directory does not exist.');
    }

    public function testItRunsTheSkeletonSeeder()
    {
        $this->seed(SkeletonSeeder::class);
        $this->assertTrue(true);
    }

    public function testItPublishesAssets()
    {
        $this->artisan('vendor:publish', ['--tag' => 'skeleton-assets'])
            ->assertExitCode(0);

        $publishedPath = public_path('vendor/skeleton/assets');
        $this->assertDirectoryExists($publishedPath, 'Assets were not published correctly.');
    }

    public function testItPublishesViews()
    {
        $this->artisan('vendor:publish', ['--tag' => 'skeleton-views'])
            ->assertExitCode(0);

        $publishedPath = resource_path('views/vendor/skeleton');
        $this->assertDirectoryExists($publishedPath, 'Views were not published correctly.');
    }

    public function testItPublishesVueComponents()
    {
        $this->artisan('vendor:publish', ['--tag' => 'skeleton-vue'])
            ->assertExitCode(0);

        $publishedPath = resource_path('js/vendor/skeleton');
        $this->assertDirectoryExists($publishedPath, 'Vue components were not published correctly.');
    }

    public function testItPublishesConfigFile()
    {
        $this->artisan('vendor:publish', ['--tag' => 'skeleton-config'])
            ->assertExitCode(0);

        $configPath = config_path('skeleton.php');
        $this->assertFileExists($configPath, 'Config file was not published correctly.');
    }

    public function testItLoadsRoutes()
    {
        $response = $this->get('/skeleton');
        $response->assertStatus(200);
        $response->assertSee('Skeleton Route');

        $response = $this->getJson('/api/1.0/skeleton-api');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Skeleton API']);
    }

    public function testItLoadsTranslations()
    {
        $translation = __('skeleton::messages.welcome');
        $this->assertEquals('Welcome to Skeleton!', $translation, 'English translation failed.');

        app()->setLocale('es');
        $translation = __('skeleton::messages.welcome');
        $this->assertEquals('¡Bienvenido a Skeleton!', $translation, 'Spanish translation failed.');
    }

    public function testInstallSkeletonPackageCommand()
    {
        $this->artisan('package-skeleton:install')
            ->expectsOutput('Installing Skeleton Package...')
            ->expectsOutput('✔ Assets published successfully.')
            ->expectsOutput('✔ Configuration published successfully.')
            ->expectsOutput('✔ Migrations published successfully.')
            ->expectsOutput('✔ Migrations ran successfully.')
            ->expectsOutput('✔ Seeders ran successfully.')
            ->expectsOutput('Skeleton Package installed successfully!')
            ->assertExitCode(0);
    }
}
