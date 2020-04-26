<?php
/**
 * @project   PhpRedis BloomFilter
 * @author    xming <980315926pxm@163.com>
 * @license   MIT
 * @link      https://github.com/php-redis/bloom-filter
 */
namespace PHPRedis\Filters;

use Exception;
use Redis;

class BloomFilter extends RedisServer
{
    /**
     * @param string $key
     * @param float $errorRate range:(0,1)
     * @param int $capacity
     *
     * @return bool
     */
    public function reserve($key, $errorRate, $capacity)
    {
        $this->connect();
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
        $this->connect();
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
        $this->connect();
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
        $this->connect();
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
        $this->connect();
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
        $this->connect();
        $arguments = [$key, $value];

        return $this->redis->rawCommand(Commands::BF_INSERT, ...$arguments);
    }

}
