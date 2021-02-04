<?php


namespace Ueberdosis\DockerHealthCheck\Middleware;

use Closure;
use Illuminate\Support\Facades\Artisan;

class ClearCacheOnInitialRequest
{
    public function handle($request, Closure $next)
    {
        $tempFile = base_path(
            config('docker-health-check.tempFile')
        );

        if (!file_exists($tempFile)) {
            try {
                touch($tempFile);
            } catch (\Exception $exception) {
            }

            collect(config('docker-health-check.commands'))->each(fn($command) => Artisan::call($command));
        }

        return $next($request);
    }
}