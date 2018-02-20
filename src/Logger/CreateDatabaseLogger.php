<?php

namespace Montross50\DatabaseLogger;

use Monolog\Logger;
use Montross50\DatabaseLogger\Monolog\Handler\DatabaseHandler;

class CreateDatabaseLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return Logger
     */
    public function __invoke(array $config)
    {
        return app(DatabaseHandler::class, [$config]);
    }
}
