<?php

namespace Tests\Unit;

use App\Models\Schedule;
use Tests\TestCase;

class ScheduleDestroyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_success_destroy_schedule()
    {
        $scheduleId = Schedule::first()->id;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . env('API_TOKEN')
        ])->delete('/api/schedules/' . $scheduleId);

        $response->assertStatus(200);
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_failure_destroy_schedule()
    {
        $scheduleId = Schedule::first()->id;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 234234234'
        ])->delete('/api/schedules/' . $scheduleId);

        $response->assertStatus(401);
    }

}
