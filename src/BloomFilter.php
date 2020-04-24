<?php
namespace xming\BloomFilter;

use Redis;

class BloomFilter extends Redis
{
    public $host = '49.233.86.162';
    public $port = 6379;
    public $auth = null;
    public $timeout = 2;

    public function __construct()
    {
        $this->connect($this->host, $this->port, $this->timeout);
        $this->auth($this->auth);
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

        return $this->rawCommand(Commands::BF_RESERVE, ...$arguments);
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

        return $this->rawCommand(Commands::BF_ADD, ...$arguments);
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

        return $this->rawCommand(Commands::BF_MADD, ...$arguments);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    public function exist($key, $value)
    {
        $arguments = [$key, $value];

        return $this->rawCommand(Commands::BF_EXISTS, ...$arguments);
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

        return $this->rawCommand(Commands::BF_MEXISTS, ...$arguments);
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

        return $this->rawCommand(Commands::BF_INSERT, ...$arguments);
    }
}