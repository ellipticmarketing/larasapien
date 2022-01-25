<?php

namespace EllipticMarketing\Larasapien\Checkers;

use Laravel\Horizon\Contracts\MasterSupervisorRepository\MasterSupervisorRepository;
use EllipticMarketing\Larasapien\Contracts\CheckerContract;
use Exception;

class HorizonChecker implements CheckerContract
{
    /**
     * Return data about cached configuration and routes.
     *
     * @return array
     */
    public function run(): array
    {
        return [
            'horizon_is_available' => $this->horizonIsAvailable(),
        ];
    }

    protected function horizonIsAvailable(): bool {
        try {
            $horizon = app(MasterSupervisorRepository::class);
        } catch (Exception $e) {
            return false;
        }

        if (count($horizon->all()) === 0) {
            return false;
        }

        if ($horizon->all()[0]->status === 'paused') {
            return false;
        }

        return true;
    }
}
