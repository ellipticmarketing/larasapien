<?php

namespace EllipticMarketing\Larasapien\Console;

use Illuminate\Console\Command;
use EllipticMarketing\Larasapien\Contracts\MonitorContract;

class CheckCommand extends Command
{
/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larasapien:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Print actual application status';

    /**
     * Execute the console command.
     *
     * @param \EllipticMarketing\Larasapien\Contracts\MonitorContract
     * @return void
     */
    public function handle(MonitorContract $monitor)
    {
        $this->line('Checking application...');

        if (! config('larasapien.token')) {
            $this->error('No access token set.');
            $this->newLine();

            return 1;
        }

        $status = $monitor->check();

        $this->newLine();
        $this->info('Larasapien application status:');
        $this->printStatus($status);

        $this->newLine();
    }

    protected function printStatus($status, $prepend = '')
    {
        foreach ($status as $key => $value) {
            if (is_array($value)) {
                $this->line("$prepend - $key: ");
                $this->printStatus($value, $prepend . '  ');
            } else {
                if (is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                } elseif (is_null($value)) {
                    $value = 'null';
                }

                $this->line("$prepend - $key: <comment>$value</comment>");
            }
        }
    }
}
