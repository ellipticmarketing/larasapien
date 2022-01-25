<?php

namespace Tests;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use EllipticMarketing\Larasapien\Checkers\ScheduleChecker;

class ScheduleCheckerTest extends TestCase
{
    /**
     * Test file creation at invoke checker.
     *
     * @return void
     */
    public function test_file_creation()
    {
        Storage::delete('_larasapien.schedulechecktime');

        App::make(ScheduleChecker::class)();
        $this->assertTrue(Storage::exists('_larasapien.schedulechecktime'));
    }

    /**
     * Test results when schedule is running.
     *
     * @return void
     */
    public function test_running_schedule()
    {
        Storage::delete('_larasapien.schedulechecktime');

        App::make(ScheduleChecker::class)();
        $this->mockTime(now()->addMinutes(4));

        $checker = App::make(ScheduleChecker::class);

        $this->assertTrue($checker->run()['schedule_is_available']);
    }

    /**
     * Test results when schedule is running.
     *
     * @return void
     */
    public function test_not_running_schedule()
    {
        Storage::delete('_larasapien.schedulechecktime');

        $checker = App::make(ScheduleChecker::class);

        $this->assertFalse($checker->run()['schedule_is_available']);

        App::make(ScheduleChecker::class)();
        $this->assertTrue($checker->run()['schedule_is_available']);

        $this->mockTime(now()->addMinutes(6));
        $this->assertFalse($checker->run()['schedule_is_available']);
    }
}
