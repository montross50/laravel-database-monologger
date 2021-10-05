<?php

namespace Montross50\DatabaseLogger\Monolog\Handler;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Config\Repository as Config;

class DatabaseHandler extends AbstractProcessingHandler
{
    protected $table;
    protected $connection;
    protected $exceptionLogLevel;
    protected $maxRecordLength;
    protected $appLogName;
    /** @var \Illuminate\Config\Repository */
    protected $config;

    public function __construct($level = Logger::DEBUG, $bubble = true, Config $config)
    {
        $this->config = $config;
        $this->table      = $this->config->get('db-logging.table');
        $this->connection = $this->config->get('db-logging.connection');
        $this->exceptionLogLevel = $this->config->get('db-logging.exception_level');
        $this->maxRecordLength = $this->config->get('db-logging.max_record_length');
        $this->appLogName = $this->config->get('db-logging.log_name');
        parent::__construct($level, $bubble);
    }

    /**
     * @param array $record
     *
     * @throws \Exception
     */
    protected function write(array $record)
    {
	$x = 1;    
	    $data = [
            'instance'    => gethostname(),
            'application' => $this->appLogName,
            'message'     => str_limit($record['message'], $this->maxRecordLength),
            'channel'     => $record['channel'],
            'level'       => $record['level'],
            'level_name'  => $record['level_name'],
            'context'     => str_limit(json_encode($record['context']), $this->maxRecordLength),
            'remote_addr' => isset($_SERVER['REMOTE_ADDR'])     ? ip2long($_SERVER['REMOTE_ADDR']) : null,
            'user_agent'  => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT']      : null,
            'created_by'  => Auth::id() > 0 ? Auth::id() : null,
            'created_at'  => $record['datetime']->format('Y-m-d H:i:s')
        ];
        try {
            DB::connection($this->connection)->table($this->table)->insert($data);
        } catch (\PDOException $exception) {
            try {
                if (DB::connection($this->connection)->getDatabaseName()) {
                    //db is connected so lets log about our failed log.
                    $failed = $data;
                    $failed['message'] = $exception->getMessage();
                    $failed['level'] = Logger::toMonologLevel($this->exceptionLogLevel);
                    $failed['level_name'] = $this->exceptionLogLevel;
                    $failed['context'] = json_encode($exception->getTrace());
                    DB::connection($this->connection)->table($this->table)->insert($failed);
                }
            } catch (\PDOException $exception) {
                //db is not connected or still failed to write. Throw exception if not in prod. Need to come up with another way to alarm probably.
                $this->throwException($exception);
            }
        } catch (\Exception $exception) {
            $this->throwException($exception);
        }
    }

    /**
     * @param $exception
     */
    private function throwException($exception)
    {
        if (in_array(app()->environment(), ['local', 'dev', 'test', 'testing'])) {
            throw $exception;
        }
    }
}
