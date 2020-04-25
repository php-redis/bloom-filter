<?php
/**
 * @project   PhpRedis BloomFilter
 * @author    xming <980315926pxm@163.com>
 * @license   MIT
 * @link      https://github.com/php-redis/bloom-filter
 */
namespace xming\filters;

use Redis;

class BloomFilter
{
    /** Redis Config */
    private $host = '127.0.0.1';
    private $port = 6379;
    private $timeout = 0.0;
    private $reserved = null;
    private $retry_interval = 0;
    private $auth = null;
    private $database = 0;
    private $redis;

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
        $this->database = $config['database'] ?? $this->database;
        $this->redis = new Redis();
        $this->redis->connect($this->host, $this->port, $this->timeout, $this->reserved, $this->retry_interval);
        $this->redis->auth($this->auth);
        $this->redis->select($this->database);
    }

    /**
     * @param string $key
     * @param float $errorRate range:(0,1)
     * @param int $capacity
     *
     * @return bool
     */
    public function reserve($key, $errorRate, $capacity)
    {
        $arguments = [$key, $errorRate, $capacity];

        return $this->redis->rawCommand(Commands::BF_RESERVE, ...$arguments);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    public function add($key, $value)
    {
        $arguments = [$key, $value];

        return $this->redis->rawCommand(Commands::BF_ADD, ...$arguments);
    }

    /**
     * @param string $key
     * @param array $values
     *
     * @return array
     */
    public function madd($key, $values)
    {
        $arguments = array_merge([$key], $values);

        return $this->redis->rawCommand(Commands::BF_MADD, ...$arguments);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    public function exists($key, $value)
    {
        $arguments = [$key, $value];

        return $this->redis->rawCommand(Commands::BF_EXISTS, ...$arguments);
    }

    /**
     * @param string $key
     * @param array $values
     *
     * @return array
     */
    public function mexists($key, $values)
    {
        $arguments = array_merge([$key], $values);

        return $this->redis->rawCommand(Commands::BF_MEXISTS, ...$arguments);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    public function insert($key, $value)
    {
        $arguments = [$key, $value];

        return $this->redis->rawCommand(Commands::BF_INSERT, ...$arguments);
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
            'auth' => $this->auth,
            'database' => $this->database,
        ];
    }
}