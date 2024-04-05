<?php

namespace Tests\Unit;

use Tests\TestCase;


class ScheduleListTest extends TestCase
{

    protected string $token = '2|9G9xngOqXx3TiQYX0eShZ2BTCygNeCfYEihLBssA8120175e';

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_success_list_schedule(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ])->get('/api/schedules');

        $response->assertStatus(200);
    }

    public function test_failure_list_schedule(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 234234'
        ])->get('/api/schedules');

        $response->assertStatus(401);
    }
}
