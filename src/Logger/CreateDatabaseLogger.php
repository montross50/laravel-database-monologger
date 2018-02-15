<?php

namespace Montross50\DatabaseLogger;

use Monolog\Logger;
use Montross50\DatabaseLogger\Monolog\Handler\DatabaselHandler;

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
        $level = Logger::DEBUG;
        $bubble = true;
        $level = $config['level'] ?? $level;
        $bubble = $config['bubble'] ?? $bubble;
        return new Logger('database', [new DatabaselHandler($level, $bubble)]);
    }
}
