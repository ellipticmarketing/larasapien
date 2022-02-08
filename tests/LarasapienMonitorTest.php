<?php

namespace Tests;

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
        $monitor = App::make(MonitorContract::class);
        $status = $monitor->check();

        $this->assertEquals('1.1.0', $status['versions']['larasapien']);
        $this->assertTrue(is_float($status['cpu_load']));
    }
}
