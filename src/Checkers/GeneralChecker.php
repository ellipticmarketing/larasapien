<?php

namespace EllipticMarketing\Larasapien\Checkers;

use EllipticMarketing\Larasapien\LarasapienMonitor;

use EllipticMarketing\Larasapien\Contracts\CheckerContract;

class GeneralChecker implements CheckerContract
{
    /**
     * Return general checks.
     *
     * @return array
     */
    public function run(): array
    {
        return [
            'versions' => [
                'larasapien' => LarasapienMonitor::VERSION,
                'laravel' => app()->version(),
                'php' => phpversion(),
            ],
            'environment' => app()->environment(),
            'debug_mode' => config('app.debug'),
        ];
    }
}
