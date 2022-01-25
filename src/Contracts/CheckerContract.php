<?php

namespace EllipticMarketing\Larasapien\Contracts;

interface CheckerContract
{
     /**
     * Run the checker, return an array which will be merged with other checker results.
     *
     * @return array
     */
    public function run(): array;
}
