<?php
namespace Montross50\DatabaseLogger;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManagerTests extends TestCase {

    /** @test */
    public function it_runs_the_migrations()
    {
        $has_table = \DB::getSchemaBuilder()->hasTable('laravel_logs');
        $this->assertTrue($has_table);
    }

    /** @test */
    public function logger_returns_monolog_instance()
    {

        $this->app->log->alert('test');
        Log::channel('database')->alert('test');

        $x = $this->app;
        $has_table = \DB::getSchemaBuilder()->hasTable('laravel_logs');
        $logs = DB::table('laravel_logs')->select('*')->get();
        $this->assertTrue($has_table);
    }
}