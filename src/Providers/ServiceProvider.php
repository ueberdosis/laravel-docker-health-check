<?php

namespace Ueberdosis\DockerHealthCheck\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/docker-health-check.php' => config_path('docker-health-check.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/docker-health-check.php', 'docker-health-check'
        );
    }
}