<?php

namespace Coreproc\NovaArtisanCards\MigrateFresh;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class MigrateFreshJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public bool $seedData = false)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed' => $this->seedData,
        ]);

        Artisan::call('cache:clear');

        Cache::set('artisan-migrate-fresh-at', now());
    }
}

