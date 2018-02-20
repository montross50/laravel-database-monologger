<?php

namespace Montross50\DatabaseLogger;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Montross50\DatabaseLogger\Monolog\Handler\DatabaseHandler;

class MonologDatabaseHandlerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        $configPath = __DIR__ . '/../../config/db-logging.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('db-logging.php');
        } else {
            $publishPath = base_path('config/db-logging.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../../config/db-logging.php';
        $this->mergeConfigFrom($configPath, 'db-logging');
        $this->app->bind(DatabaseHandler::class, function ($app, $params) {
            $level = Logger::DEBUG;
            $bubble = true;
            $level = $params['level'] ?? $level;
            $bubble = $params['bubble'] ?? $bubble;
            return new Logger('database', [new DatabaseHandler($level, $bubble, $app['config'])]);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
