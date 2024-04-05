<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{

    /**
     * Test of Login - Success
     *
     * @return void
     */
    public function test_success_login(): void
    {
        $data = [
            'email' => 'test@email.com',
            'password' => '123456'
        ];

        $user = User::where(['email' => $data['email']])->first();

        if($user || Hash::check($data['password'], $user->password)) {
            $response = $this->withHeaders(['Accept' => 'application/json'])
                         ->post('/api/login', $data);

            $response->assertStatus(202);
        }
    }

    /**
     * Test of Login - Error
     *
     * @return void
     */
    public function test_failure_login(): void
    {
        $data = [
            'email' => 'failure@email.com',
            'password' => '64646446464'
        ];

        $user = User::where(['email' => $data['email']])->first();

        if(!$user || !Hash::check($data['password'], $user->password)) {
            $response = $this->withHeaders(['Accept' => 'application/json'])
                         ->post('/api/login', $data);

            $response->assertStatus(401);
        }
    }



}
