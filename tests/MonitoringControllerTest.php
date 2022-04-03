<?php

namespace Tests;

use EllipticMarketing\Larasapien\LarasapienMonitor;

class MonitoringControllerTest extends TestCase
{
    /**
     * Test Larasapien endpoint.
     *
     * @return void
     */
    public function test_index()
    {
        $version = LarasapienMonitor::VERSION;

        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . 'base64:dIaqqebxrdJYi8aWX3TsbQj+tYEXCohe/zmMCJjd30I='
            ])->post(route('larasapien.index'));

        $response
            ->assertStatus(200);

        $this->assertEquals($response->decodeResponseJson()['versions']['larasapien'], $version);
    }

    public function test_refuse_request_if_bearer_is_not_present()
    {
        $response = $this->post(route('larasapien.index'));

        $response->assertStatus(403);
    }

    public function test_refuse_request_if_bearer_is_invalid()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . 'base64:a5kS3VfVt9ERCO2ZKkYudHYzCyluiyI0nXEG8AABUsg='
        ])->post(route('larasapien.index'));

        $response->assertStatus(403);
    }

    public function test_refuse_request_if_no_token_set()
    {
        config(['larasapien.token' => null]);

        $response = $this->post(route('larasapien.index'));

        $response->assertStatus(403);
    }
}
