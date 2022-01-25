<?php

namespace EllipticMarketing\Larasapien\Http\Controllers;

use EllipticMarketing\Larasapien\Contracts\MonitorContract;

class MonitoringController extends Controller
{
    protected $monitor;

    public function __construct(MonitorContract $monitor)
    {
        parent::__construct();

        $this->monitor = $monitor;
    }

    /**
     * Get application status.
     *
     * @return \Illuminate\Support\Collection
     */
    public function __invoke()
    {
        return $this->monitor->check();
    }
}
