<?php

namespace Tests;

use Illuminate\Support\Facades\App;
use EllipticMarketing\Larasapien\Checkers\GitChecker;

class GitCheckerTest extends TestCase
{
    /**
     * Test Larasapien Monitor check method.
     *
     * @return void
     */
    public function test_check_method()
    {
        $checker = new GitChecker(__DIR__ . '/../.git');
        $output = $checker->run()['git'];

        $this->assertTrue($output['enabled']);
        $this->assertCount(2, $output['last_commit']);
    }

    /**
     * Test Larasapien Monitor check method.
     *
     * @return void
     */
    public function test_custom_path()
    {
        $checker = new GitChecker();
        $this->assertEquals(base_path('.git'), $checker->getRepositoryPath());

        $checker = new GitChecker(__DIR__ . '/../.git');
        $this->assertEquals(__DIR__ . '/../.git', $checker->getRepositoryPath());
    }
}
