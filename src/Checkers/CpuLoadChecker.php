<?php

namespace EllipticMarketing\Larasapien\Checkers;

use EllipticMarketing\Larasapien\Contracts\CheckerContract;

class CpuLoadChecker implements CheckerContract
{
    /**
     * Return CPU load.
     *
     * @return array
     */
    public function run(): array
    {
        $load = null;

        if (stristr(PHP_OS, "win")) {
            exec('wmic cpu get loadpercentage /all', $output);

            if ($output) {
                foreach ($output as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $load = $line;
                    }
                }

                $load = floatval($load) / 100;
            }
        } else {
            $load = collect(sys_getloadavg())->avg();
        }

        return [ 'cpu_load' => $load ];
    }
}
