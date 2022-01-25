<?php
namespace Montross50\DatabaseLogger;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [MonologDatabaseHandlerServiceProvider::class];
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
            'via' => CreateDatabaseLogger::class,
        ];
        $app['config']->set('logging.channels', $channels);
        $app['config']->set('logging.default', 'database');
    }

    public function setUp(): void
    {
        ini_set('memory_limit', '512M');
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'mysql']);
        $this->loadLaravelMigrations(['--database' => 'mysql']);
    }
}
