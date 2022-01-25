<?php

namespace EllipticMarketing\Larasapien\Checkers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use EllipticMarketing\Larasapien\Contracts\CheckerContract;

class ScheduleChecker implements CheckerContract
{
    /**
     * Filename to store time.
     *
     * @var string
     */
    protected $filename;

    /**
     * Max valid time diff between last time schedule runs and now.
     *
     * @var int
     */
    protected $valid_time_diff;

    /**
     * Configured disk instance.
     *
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    protected $disk;

    public function __construct()
    {
        $this->disk = Storage::disk(config('larasapien.options.schedule.disk'));
        $this->filename = config('larasapien.options.schedule.filename');
        $this->valid_time_diff = config('larasapien.options.schedule.valid_time_diff');
    }

    /**
     * Write a file to check later if schedule is working correctly.
     *
     * @return void
     */
    public function __invoke()
    {
        $this->disk->put($this->filename, now()->timestamp);
    }

    /**
     * Check if schedule is available.
     *
     * @return array
     */
    public function run(): array
    {
        if ($this->disk->exists($this->filename)) {
            $time = (int) $this->disk->get($this->filename);
        }

        return [
            'schedule_is_available' => isset($time) ? $this->valid_time_diff > (now()->timestamp - $time) : false
        ];
    }
}
