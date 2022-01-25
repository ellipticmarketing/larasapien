<?php

namespace EllipticMarketing\Larasapien\Contracts;

use Illuminate\Support\Collection;

interface MonitorContract
{
     /**
     * Check actual application status.
     *
     * @return \Illuminate\Support\Collection
     */
    public function check(): Collection;

    /**
     * Register a new checker.
     *
     * @return self
     */
    public function checker(string $checker);

    /**
     * Run an individual checker.
     *
     * @return array
     */
    public function run(CheckerContract $checker): array;
}
