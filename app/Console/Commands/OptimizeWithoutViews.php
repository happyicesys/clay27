<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class OptimizeWithoutViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:no-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the application without caching views (for Inertia apps)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->components->info('Optimizing application (without view caching)...');

        // Clear all caches first
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('event:clear');

        // Cache config and routes (skip views)
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('event:cache');

        $this->components->info('Application optimized successfully!');

        return Command::SUCCESS;
    }
}
