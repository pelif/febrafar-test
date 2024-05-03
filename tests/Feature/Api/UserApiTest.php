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
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'last_page',
                'first_page',
                'per_page'
            ],
            'data'
        ]);

        $response->assertJsonFragment(['total' => 40]);
        $response->assertJsonFragment(['current_page' => 1]);
        $response->assertJsonFragment(['per_page' => 15]);
    }

    public function testPageTwo()
    {
        User::factory()
            ->count(20)
            ->create();

        $response = $this->getJson("{$this->endpoint}/paginate?page=2");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'last_page',
                'first_page',
                'per_page'
            ],
            'data'
        ]);

        $response->assertJsonFragment(['total' => 20]);
        $response->assertJsonFragment(['current_page' => 2]);
        $response->assertJsonFragment(['per_page' => 15]);
    }



}
