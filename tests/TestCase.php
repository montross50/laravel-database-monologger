<?php
namespace Montross50\DatabaseLogger;


abstract class TestCase extends \Orchestra\Testbench\TestCase {

    protected function getPackageProviders($app)
    {
        return [MonologMysqlHandlerServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $channels = $app['config']->get('logging.channels');
        $channels['database'] = [
            'driver' => 'custom',
            'via' => DatabaseLogger::class,
        ];
        $app['config']->set('logging.channels', $channels);
        $app['config']->set('logging.default', 'database');
    }

    public function setUp()
    {
        ini_set('memory_limit', '512M');
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testing']);
        $this->loadLaravelMigrations(['--database' => 'testing']);
    }
}