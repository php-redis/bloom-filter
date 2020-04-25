# PHP Redis Bloom Filter

## Install
composer require php-redis/bloom-filter

## Requirements
redis version >= 4.0  
php version >= 7.2  
Installed plug-ins [RedisBloom](https://github.com/RedisBloom/RedisBloom)

## How to install RedisBloom plug-ins ?
git clone https://github.com/RedisBloom/RedisBloom.git  
mv RedisBloom /usr/local  
cd RedisBloom  
make  

vi /etc/redis/redis.conf  
loadmodule /usr/local/RedisBloom/redisbloom.so INITIAL_SIZE 1000 ERROR_RATE 0.001  

## Basic Usage
```php
<?php

use phpredis\filters\BloomFilter;

// options：host part auth timeout reserved retry_interval database 
$bloomFilter = new BloomFilter();
$bloomFilter = new BloomFilter(['host' => '192.168.20.6']);
$bloomFilter = new BloomFilter(['host' => '192.168.20.6', 'part'=>6379]);
$bloomFilter = new BloomFilter(['host' => '192.168.20.6', 'part'=>6380, 'auth' => 123456]);
// 新建过滤器 $errorRate：容错率取值范围(0,1) $capacity：容量
$bool = $bloomFilter->reserve('key', 0.001, 1000);
// 过滤器添加单个值
$bool = $bloomFilter->add('key', 'value');
$bool = $bloomFilter->insert('key', 'value');
// 过滤器添加多个值
$array = $bloomFilter->madd('key', ['value1','value2','value3']);
// 检测过滤器是否存在单个值
$bool = $bloomFilter->exists('key', 'value');
// 检测过滤器是否存在多个值
$array = $bloomFilter->mexists('key', ['value1','value2','value3']);
// 获取 Redis 配置参数
$config = $bloomFilter->getConfig();