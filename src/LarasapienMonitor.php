<?php

namespace EllipticMarketing\Larasapien;

use Illuminate\Support\Collection;
use EllipticMarketing\Larasapien\Contracts\MonitorContract;
use EllipticMarketing\Larasapien\Contracts\CheckerContract;
use Exception;

class LarasapienMonitor implements MonitorContract
{
    /**
     * Larasapien version.
     *
     * @var string
     */
    const VERSION = '1.0.1';

    /**
     * All registered checkers.
     *
     * @var array
     */
    protected $checkers;

    public function __construct(array $checkers = []) {
        $this->checkers = $checkers;
    }

    /**
     * Check actual application status.
     *
     * @return \Illuminate\Support\Collection
     */
    public function check(): Collection
    {
        $output = collect([ 'reported_at' => now()->toIso8601String() ]);

        foreach ($this->checkers as $checker) {
            $output = $output->merge($this->run(app()->make($checker)));
        }

        return $output;
    }

    /**
     * Register a new checker.
     *
     * @return self
     */
    public function checker(string $checker)
    {
        $this->checkers[] = $checker;
        return $this;
    }

    /**
     * Run an individual checker.
     *
     * @return array
     */
    public function run(CheckerContract $checker): array
    {
        return $checker->run();
    }
}
