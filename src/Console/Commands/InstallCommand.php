<?php

namespace Eresendez\PackageSkeleton\Console\Commands;

use Eresendez\PackageSkeleton\Seeders\PackageSeeder;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'package-skeleton:install';

    /**
     * The console command description.
     */
    protected $description = 'Install the Skeleton Package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Installing Package...');

        // Publish assets
        $this->call('vendor:publish', [
            '--tag' => 'package-assets',
            '--force' => true,
        ]);
        $this->info('✔ Assets published successfully.');

        // Publish config
        $this->call('vendor:publish', [
            '--tag' => 'package-config',
            '--force' => true,
        ]);
        $this->info('✔ Configuration published successfully.');

        // Publish migrations
        $this->call('vendor:publish', [
            '--tag' => 'package-migrations',
            '--force' => true,
        ]);
        $this->info('✔ Migrations published successfully.');

        // Run migrations
        $this->call('migrate');
        $this->info('✔ Migrations ran successfully.');

        // Seed database
        $this->call('db:seed', [
            '--class' => PackageSeeder::class,
        ]);
        $this->info('✔ Seeders ran successfully.');

        $this->info('Package installed successfully!');
    }
}
