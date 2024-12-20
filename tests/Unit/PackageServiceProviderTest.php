<?php

namespace Tests\Unit;

use Eresendez\PackageSkeleton\PackageServiceProvider;
use Eresendez\PackageSkeleton\Seeders\PackageSeeder;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class PackageServiceProviderTest extends TestCase
{
    private const VENDOR_PUBLISH = 'vendor:publish';

    private const OPTION_TAG = '--tag';

    /**
     * Get package providers.
     */
    protected function getPackageProviders($app): array
    {
        return [
            PackageServiceProvider::class,
        ];
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(public_path('vendor/package-skeleton'));
        File::deleteDirectory(resource_path('views/vendor/package-skeleton'));
        File::deleteDirectory(resource_path('js/vendor/package-skeleton'));
        File::delete(config_path('package-skeleton.php'));

        parent::tearDown();
    }

    public function testItLoadsMigrations()
    {
        $migrationPath = database_path('migrations');
        $this->artisan('migrate')->assertExitCode(0);

        $this->assertDirectoryExists($migrationPath, 'Migration directory does not exist.');
    }

    public function testItRunsThePackageSeeder()
    {
        $this->seed(PackageSeeder::class);
        $this->assertTrue(true);
    }

    public function testItPublishesAssets()
    {
        $this->artisan(self::VENDOR_PUBLISH, [self::OPTION_TAG => 'package-assets'])
            ->assertExitCode(0);

        $publishedPath = public_path('vendor/package-skeleton/assets');
        $this->assertDirectoryExists($publishedPath, 'Assets were not published correctly.');
    }

    public function testItPublishesViews()
    {
        $this->artisan(self::VENDOR_PUBLISH, [self::OPTION_TAG => 'package-views'])
            ->assertExitCode(0);

        $publishedPath = resource_path('views/vendor/package-skeleton');
        $this->assertDirectoryExists($publishedPath, 'Views were not published correctly.');
    }

    public function testItPublishesVueComponents()
    {
        $this->artisan(self::VENDOR_PUBLISH, [self::OPTION_TAG => 'package-vue'])
            ->assertExitCode(0);

        $publishedPath = resource_path('js/vendor/package-skeleton');
        $this->assertDirectoryExists($publishedPath, 'Vue components were not published correctly.');
    }

    public function testItPublishesConfigFile()
    {
        $this->artisan(self::VENDOR_PUBLISH, [self::OPTION_TAG => 'package-config'])
            ->assertExitCode(0);

        $configPath = config_path('package-skeleton.php');
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
        $translation = __('package-skeleton::messages.welcome');
        $this->assertEquals('Welcome to Skeleton!', $translation, 'English translation failed.');

        app()->setLocale('es');
        $translation = __('package-skeleton::messages.welcome');
        $this->assertEquals('¡Bienvenido a Skeleton!', $translation, 'Spanish translation failed.');
    }

    public function testInstallPackageCommand()
    {
        $this->artisan('package-skeleton:install')
            ->expectsOutput('Installing Package...')
            ->expectsOutput('✔ Assets published successfully.')
            ->expectsOutput('✔ Configuration published successfully.')
            ->expectsOutput('✔ Migrations published successfully.')
            ->expectsOutput('✔ Migrations ran successfully.')
            ->expectsOutput('✔ Seeders ran successfully.')
            ->expectsOutput('Package installed successfully!')
            ->assertExitCode(0);
    }
}
