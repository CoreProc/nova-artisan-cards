<?php

namespace Coreproc\NovaArtisanCards\MigrateFresh;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class MigrateFreshController extends Controller
{
    public function __invoke(Request $request): void
    {
        Log::info('[MigrateFreshController] Running MigrateFreshJob', [
            'seedData' => $request->get('seedData', false),
        ]);

        dispatch(new MigrateFreshJob($request->get('seedData', false)))
            ->onQueue(config('nova-artisan-cards.migrate_fresh.queue', 'default'));

        auth()->logout();
    }
}
