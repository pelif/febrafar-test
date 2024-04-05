<?php

namespace Tests\Unit;

use Tests\TestCase;

class ScheduleStoreTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_success_store_schedule(): void
    {

        $data = [
            'title' => 'Test Schedule' . rand(1000, 1000000),
            'description' => 'Test Description Schedule',
            'status' => '0',
            'start' => date('Y-m-d'),
            'deadline' => ( new \Carbon\Carbon(date('Y-m-d')) )->addDays(10),
            'user_id' => 1
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . env('API_TOKEN')
        ])->post('/api/schedules', $data);

        $response->assertStatus(200);
    }


    /**
     * test_failure_store_schedule
     *
     * @return void
     */
    public function test_failure_store_schedule(): void
    {
        $data = [
            'title' => 'Test Schedule' . rand(1000, 1000000),
            'description' => 'Test Description Schedule',
            'status' => '0',
            'start' => date('Y-m-d'),
            'deadline' => ( new \Carbon\Carbon(date('Y-m-d')) )->addDays(10),
            'user_id' => 1
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 234234'
        ])->post('/api/schedules', $data);

        $response->assertStatus(401);
    }
}
