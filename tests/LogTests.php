<?php
namespace Montross50\DatabaseLogger;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Montross50\DatabaseLogger\Monolog\Handler\DatabaseHandler;

class LogTests extends TestCase
{

    /** @test */
    public function it_runs_the_migrations()
    {
        $has_table = DB::getSchemaBuilder()->hasTable('laravel_logs');
        $this->assertTrue($has_table);
    }

    /** @test */
    public function logger_returns_database_handler()
    {
        /**
         * @var $logger Logger
         */
        $logger = Log::getLogger();
        $this->assertInstanceOf(Logger::class, $logger);
        $handler = current($logger->getHandlers());
        $this->assertInstanceOf(DatabaseHandler::class, $handler);
    }

    /** @test */
    public function logger_logs()
    {
        Log::alert('test1');
        $ctx = ['data'=>'foo'];
        Log::critical('test2', $ctx);
        $logs = DB::table('laravel_logs')->select('*')->get();
        $this->assertEquals('test1', $logs[0]->message);
        $this->assertEquals('test2', $logs[1]->message);
        $this->assertEquals(json_encode(['data'=>'foo']), $logs[1]->context);
    }

    /**
     * @test
     */
    public function logger_fail_logs()
    {
        $message = "test1";
        $exception = "failed";
        $connection = DB::connection('mysql');
        $query = \Mockery::mock(Builder::class)->makePartial();
        $query->connection = $connection;
        $query->from('laravel_logs');
        $query->grammar = $connection->getQueryGrammar();
        $query->processor = $connection->getPostProcessor();
        $query->shouldReceive('getDatabaseName')
            ->once()->andReturn(true);
        $query->shouldReceive('insert')
            ->once()
            ->with(\Mockery::on(function ($argument) use ($message) {
                if ($argument['message'] == $message) {
                    return true;
                }
                return false;
            }))
            ->andThrow(new \PDOException($exception));

        $query->shouldReceive('insert')
            ->once()
            ->with(\Mockery::on(function ($argument) use ($exception) {
                if ($argument['message'] == $exception) {
                    return true;
                }
                return false;
            }))
            ->passthru();

        $query->shouldReceive('table')
            ->andReturn($query);
        $db = DB::getFacadeRoot();
        DB::shouldReceive('connection')
            ->with('mysql')
            ->andReturn($query);
        Log::alert($message);
        DB::swap($db);

        $logs = DB::table('laravel_logs')->select('*')->get();
        $this->assertEquals($exception, $logs[0]->message);
        $this->assertEquals(config('db-logging.exception_level'), $logs[0]->level_name);
    }

    /**
     * @expectedException \PDOException
     */
    public function logger_fail_on_connection_not_established()
    {
        $message = "test1";
        $exception = "failed";
        $query = \Mockery::mock(Builder::class)->makePartial();
        $query->shouldReceive('getDatabaseName')->andThrow(new \PDOException())
            ->once()->andReturn(true);

        $query->shouldReceive('insert')
            ->once()
            ->with(\Mockery::on(function ($argument) use ($message) {
                if ($argument['message'] == $message) {
                    return true;
                }
                return false;
            }))
            ->andThrow(new \PDOException($exception));
    }

    /** @test
     *  @expectedException \InvalidArgumentException
     */
    public function logger_fail_on_connection_not_found()
    {
        config(['db-logging.connection' => 'foobar']);
        Log::alert('test1');
    }

    /** @test */
    public function logger_obeys_max_length()
    {
        config(['db-logging.max_record_length' => 8]);
        Log::alert('123456789');
        $logs = DB::table('laravel_logs')->select('*')->get();
        $this->assertEquals('12345678...', $logs[0]->message);
    }
}
