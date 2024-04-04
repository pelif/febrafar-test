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
            'email' => 'Test',
            'password' => bcrypt('123456')
        ];

        User::firstOrNew($data, $data);
    }

}
