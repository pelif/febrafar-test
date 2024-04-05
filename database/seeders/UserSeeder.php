<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            'name' => 'Test',
            'email' => 'test@email.com',
            'password' => bcrypt('123456')
        ];

        User::firstOrCreate($data, $data);
    }

}
