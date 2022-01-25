<?php

namespace EllipticMarketing\Larasapien\Checkers;

use Illuminate\Support\Facades\Redis;
use EllipticMarketing\Larasapien\Contracts\CheckerContract;
use Exception;

class RedisChecker implements CheckerContract
{
    /**
     * Return data about cached configuration and routes.
     *
     * @return array
     */
    public function run(): array
    {
        return [
            'redis_is_available' => $this->redisIsAvailable(),
        ];
    }

    protected function redisIsAvailable(): bool
    {
        if (!class_exists('Redis')) {
            return false;
        }

        try {
            $key = config('larasapien.options.redis.key');
            $time = time();

            Redis::set($key, $time);

            return Redis::get($key) == $time;
        } catch (Exception $e) {
            return false;
        }
    }
}
