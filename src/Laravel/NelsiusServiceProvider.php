<?php

namespace Nelsius\Laravel;

use Illuminate\Support\ServiceProvider;
use Nelsius\NelsiusClient;

class NelsiusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/nelsius.php', 'nelsius');

        $this->app->singleton(NelsiusClient::class, function ($app) {
            $config = $app['config']['nelsius'] ?? [];
            $apiKey = $config['secret_key'] ?: $config['public_key'];

            return new NelsiusClient($apiKey, [
                'base_url' => $config['base_url'] ?? 'https://api.nelsiuspay.com/api/v1',
                'timeout'  => $config['timeout'] ?? 30,
            ]);
        });

        $this->app->alias(NelsiusClient::class, 'nelsius');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/nelsius.php' => config_path('nelsius.php'),
            ], 'nelsius-config');
        }
    }
}
