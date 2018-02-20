<?php

return [

    'table' => env('DB_LOG_TABLE', 'laravel_logs'),
    'connection' => env('DB_LOG_CONNECTION', env('DB_CONNECTION', 'mysql')),
    'exception_level' => env('DB_LOG_EXCEPTION_LOG_LEVEL','alert'),
    'max_record_length' => env('DB_LOG_MAX_RECORD_LENGTH',65500),
    'log_name' => env('APP_LOG_NAME', 'unknown')

];