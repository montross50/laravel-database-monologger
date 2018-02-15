<?php
namespace Montross50\DatabaseLogger;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Montross50\DatabaseLogger\Monolog\Handler\DatabaselHandler;

class ManagerTests extends TestCase {

    /** @test */
    public function it_runs_the_migrations()
    {
        $has_table = \DB::getSchemaBuilder()->hasTable('laravel_logs');
        $this->assertTrue($has_table);
    }

    /** @test */
    public function logger_returns_database_handler()
    {
        /**
         * @var $logger Logger
         */
        $logger = Log::getLogger();
        $this->assertInstanceOf(Logger::class,$logger);
        $handler = current($logger->getHandlers());
        $this->assertInstanceOf(DatabaselHandler::class,$handler);
    }

    /** @test */
    public function logger_logs()
    {

        Log::alert('test1');
        $ctx = ['data'=>'foo'];
        Log::critical('test2',$ctx);
        $logs = \DB::table('laravel_logs')->select('*')->get();
        $this->assertEquals('test1',$logs[0]->message);
        $this->assertEquals('test2',$logs[1]->message);
        $this->assertEquals(json_encode(['data'=>'foo']),$logs[1]->context);
    }
}