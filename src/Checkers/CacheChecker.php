<?php

namespace EllipticMarketing\Larasapien\Checkers;

use EllipticMarketing\Larasapien\Contracts\CheckerContract;

class CacheChecker implements CheckerContract
{
    /**
     * Return data about cached configuration and routes.
     *
     * @return array
     */
    public function run(): array
    {
        return [
            'routes_are_cached' => app()->routesAreCached(),
            'configuration_is_cached' => app()->configurationIsCached(),
        ];
    }
}
