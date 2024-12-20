<?php

namespace Eresendez\PackageSkeleton\Console\Commands;

use Eresendez\PackageSkeleton\Seeders\SkeletonSeeder;
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
        $this->info('Installing Skeleton Package...');

        // Publish assets
        $this->call('vendor:publish', [
            '--tag' => 'skeleton-assets',
            '--force' => true,
        ]);
        $this->info('✔ Assets published successfully.');

        // Publish config
        $this->call('vendor:publish', [
            '--tag' => 'skeleton-config',
            '--force' => true,
        ]);
        $this->info('✔ Configuration published successfully.');

        // Publish migrations
        $this->call('vendor:publish', [
            '--tag' => 'skeleton-migrations',
            '--force' => true,
        ]);
        $this->info('✔ Migrations published successfully.');

        // Run migrations
        $this->call('migrate');
        $this->info('✔ Migrations ran successfully.');

        // Seed database
        $this->call('db:seed', [
            '--class' => SkeletonSeeder::class,
        ]);
        $this->info('✔ Seeders ran successfully.');

        $this->info('Skeleton Package installed successfully!');
    }
}
