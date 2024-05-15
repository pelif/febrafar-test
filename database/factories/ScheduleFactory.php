<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $now = \Carbon\Carbon::now();
        $faker = \Faker\Factory::create('pt-BR');

        User::factory()->count(3)->create();

        return [
            'title' => $faker->title(),
            'description' => $faker->name(),
            'status' => $faker->randomElement([0,1]),
            'start' => $now->add(rand(1,100), 'day')->toDate(),
            'deadline' => $now->add(rand(1,500), 'day')->toDate(),
            'completion' => $now->add(rand(1,300), 'day')->toDate(),
            'user_id' => User::first()->id
        ];
    }
}
