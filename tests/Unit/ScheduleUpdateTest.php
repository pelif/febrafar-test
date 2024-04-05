<?php

namespace Tests\Unit;

use App\Models\Schedule;
use Tests\TestCase;

class ScheduleUpdateTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_success_update_schedule(): void
    {
        $data = [
            'title' => 'Test Schedule' . rand(1000, 1000000),
            'description' => 'Test Description Schedule',
            'status' => '0',
            'start' => date('Y-m-d'),
            'deadline' => ( new \Carbon\Carbon(date('Y-m-d')) )->addDays(10),
            'user_id' => 1
        ];

        $id = Schedule::first()->id;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . env('API_TOKEN')
        ])->put('/api/schedules/'.$id, $data);


        $response->assertStatus(200);
    }

    public function test_failure_update_schedule(): void
    {
        $data = [
            'title' => 'Test Schedule' . rand(1000, 1000000),
            'description' => 'Test Description Schedule',
            'status' => '0',
            'start' => date('Y-m-d'),
            'deadline' => ( new \Carbon\Carbon(date('Y-m-d')) )->addDays(10),
            'user_id' => 1
        ];

        $id = Schedule::first()->id;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 1231231'
        ])->put('/api/schedules/'.$id, $data);


        $response->assertStatus(401);
    }
}
