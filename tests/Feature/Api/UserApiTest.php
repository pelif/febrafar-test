<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    protected string $endpoint = '/api/users';

    public function testFindAllEmpty()
    {
        $response = $this->getJson($this->endpoint);
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function testFindAll()
    {
        User::factory()->count(40)->create();

        $response = $this->getJson($this->endpoint);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(40, 'data');

    }

    public function testPaginate()
    {
        User::factory()->count(40)->create();

        $response = $this->getJson($this->endpoint . '/paginate');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(15, 'data');

    }



}
