<?php

namespace Coreproc\NovaArtisanCards\ArtisanCall;

use Coreproc\NovaArtisanCards\ArtisanCall\Requests\ArtisanCallRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use function Coreproc\NovaArtisanCards\HorizonClear\base_path;
use function Coreproc\NovaArtisanCards\HorizonClear\response;

class ArtisanCallController extends Controller
{
    public function run(ArtisanCallRequest $artisanCallRequest): JsonResponse
    {
        $artisanCall = $artisanCallRequest->get('command');

        $command = ['php', base_path('artisan')];
        if (isset($artisanCall)) {
            $command[] = escapeshellarg($artisanCall);
        }

        $process = new Process($command);

        try {
            $process->mustRun();

            return response()->json([
                'success' => true,
                'message' => 'Artisan call ran successfully.',
                'output' => $process->getOutput()
            ]);
        } catch (ProcessFailedException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to run artisan command.',
                'error' => $exception->getMessage(),
                'output' => $process->getOutput()
            ], 500);
        }
    }
}