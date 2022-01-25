<?php

namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use EllipticMarketing\Larasapien\LarasapienServiceProvider;
use Carbon\Carbon;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [LarasapienServiceProvider::class];
    }

    protected function mockTime(Carbon $time)
    {
        Carbon::setTestNow($time);
    }
}
