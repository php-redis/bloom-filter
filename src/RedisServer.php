<?php
/**
 * @project   Redis Server
 * @author    xming <980315926pxm@163.com>
 */
namespace PHPRedis\Filters;

use Exception;
use Redis;

class RedisServer
{
    /** Redis Config */
    private $host = '127.0.0.1';
    private $port = 6379;
    private $timeout = 0.0;
    private $reserved = null;
    private $retry_interval = 0;
    private $read_timeout = 0.0;
    private $auth = null;
    private $database = 0;
    protected $redis;

    /**
     * @param array|null $config
     */
    public function __construct($config = null)
    {
        $this->host = $config['host'] ?? $this->host;
        $this->port = $config['port'] ?? $this->port;
        $this->timeout = $config['timeout'] ?? $this->timeout;
        $this->reserved = $config['reserved'] ?? $this->reserved;
        $this->retry_interval = $config['retry_interval'] ?? $this->retry_interval;
        $this->read_timeout = $config['read_timeout'] ?? $this->read_timeout;
        $this->database = $config['database'] ?? $this->database;
    }

    /**
     * Connect to Redis
     */
    protected function connect()
    {
        try{
            $this->redis = new Redis();
            $this->redis->connect($this->host, $this->port, $this->timeout, $this->reserved, $this->retry_interval, $this->read_timeout);
            $this->redis->auth($this->auth);
            $this->redis->select($this->database);
        }catch (Exception $e){
            throw new Exception("connect to Redis server failed");
        }
    }

    /**
     * @param string $host
     *
     * @return RedisServer
     */
    public function setHost($host) : RedisServer
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $port
     *
     * @return RedisServer
     */
    public function setPort($port) : RedisServer
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $auth
     *
     * @return RedisServer
     */
    public function setAuth($auth) : RedisServer
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param int $database
     *
     * @return RedisServer
     * @throws Exception
     */
    public function setDatabase($database) : RedisServer
    {
        if($database < 0 || $database > 15){
            throw new Exception(sprintf("redis database value out of range, expected: 0-15, assigned: %d", $database));
        }
        $this->database = $database;
        return $this;
    }

    /**
     * @return int
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param float $timeout
     *
     * @return RedisServer
     */
    public function setTimeout($timeout) : RedisServer
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return float
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param null $reserved
     *
     * @return RedisServer
     */
    public function setReserved($reserved) : RedisServer
    {
        $this->reserved = $reserved;
        return $this;
    }

    /**
     * @return float
     */
    public function getReserved()
    {
        return $this->reserved;
    }

    /**
     * @param float $retry_interval
     *
     * @return RedisServer
     */
    public function setRetryInterval($retry_interval) : RedisServer
    {
        $this->retry_interval = $retry_interval;
        return $this;
    }

    /**
     * @return float
     */
    public function getRetryInterval()
    {
        return $this->reserved;
    }

    /**
     * @param float $read_timeout
     *
     * @return RedisServer
     */
    public function setReadTimeout($read_timeout) : RedisServer
    {
        $this->read_timeout = $read_timeout;
        return $this;
    }

    /**
     * @return float
     */
    public function getReadTimeout()
    {
        return $this->read_timeout;
    }

    /**
     * @param string $host
     * @param int $port
     * @param string $auth
     * @param float $timeout
     * @param null $reserved
     * @param int $retry_interval
     * @param float $read_timeout
     *
     * @return RedisServer
     */
    public function setConfig($host = '127.0.0.1', $port = 6379, $auth = null, $database = 0, $timeout = 0.0, $reserved = null, $retry_interval = 0, $read_timeout = 0.0) : RedisServer
    {
        $this->host = $host;
        $this->port = $port;
        $this->auth = $auth;
        $this->database = $database;
        $this->timeout = $timeout;
        $this->reserved = $reserved;
        $this->retry_interval = $retry_interval;
        $this->read_timeout = $read_timeout;
        return $this;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return [
            'host' => $this->host,
            'port' => $this->port,
            'timeout' => $this->timeout,
            'reserved' => $this->reserved,
            'retry_interval' => $this->retry_interval,
            'read_timeout' => $this->read_timeout,
            'auth' => $this->auth,
            'database' => $this->database,
        ];
    }
}
