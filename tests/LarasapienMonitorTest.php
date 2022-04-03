<?php

namespace Tests;

use EllipticMarketing\Larasapien\LarasapienMonitor;
use Illuminate\Support\Facades\App;
use EllipticMarketing\Larasapien\Contracts\MonitorContract;

class LarasapienMonitorTest extends TestCase
{
    /**
     * Test Larasapien Monitor check method.
     *
     * @return void
     */
    public function test_check_method()
    {
        $version = LarasapienMonitor::VERSION;

        $monitor = App::make(MonitorContract::class);
        $status = $monitor->check();

        $this->assertEquals($version, $status['versions']['larasapien']);
        $this->assertTrue(is_float($status['cpu_load']));
    }
}
