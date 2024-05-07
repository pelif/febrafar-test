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

    // public function testFindAll()
    // {
    //     User::factory()->count(40)->create();

    //     $response = $this->getJson($this->endpoint);
    //     $response->assertStatus(Response::HTTP_OK);
    //     $response->assertJsonCount(40, 'data');

    // }

    /**
     * @dataProvider dataProviderPagination
     */
    public function testPaginate(
        int $total,
        int $page = 1,
        int $totalPage
    )
    {

        User::factory()->count($total)->create();

        $response = $this->getJson($this->endpoint . '/paginate?page=' . $page);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount($totalPage, 'data');
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'last_page',
                'first_page',
                'per_page'
            ],
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email'
                ]
            ]
        ]);

        $response->assertJsonFragment(['total' => $total]);
        $response->assertJsonFragment(['current_page' => $page]);
        // $response->assertJsonFragment(['per_page' => $totalPage]);
    }


    public function dataProviderPagination(): array
    {
        return [
            'Test empty Users' => [
                'total' => 0,
                'page' => 1,
                'totalPage' => 0
            ],
            'Test total 10 users page One' => [
                'total' => 40,
                'page' => 1,
                'totalPage' => 15
            ],
            'Test total 20 users Page Two' => [
                'total' => 20,
                'page' => 2,
                'totalPage' => 5
            ],
            'Test total 100 users Page Two' => [
                'total' => 100,
                'page' => 2,
                'totalPage' => 15
            ],
        ];
    }


    /**
     * @dataProvider dataProviderCreateUser
     */
   public function testCreate(
        array $payload,
        int $statusCode,
        array $strutucreResponse
   ): void
   {
        $response = $this->postJson($this->endpoint, $payload);
        $response->assertStatus($statusCode);
        $response->assertJsonStructure($strutucreResponse);
   }

   public function testCreateValidations(): void
   {
        $payload = [
            'email' => 'pelif.elnida@email.com.br',
            'password' => '12345678'
        ];

        $response = $this->postJson($this->endpoint, $payload);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
   }

   public function dataProviderCreateUser(): array
   {
        return [
            'Test created with correct data' =>
            [
                'payload' => [
                    'name' => 'Pelif Elnida',
                    'email' => 'pelif.elnida@email.com.br',
                    'password' => '12345678'
                ],
                'statusCode' => Response::HTTP_CREATED,
                'structureResponse' => [
                    'data' => [
                        'id',
                        'name',
                        'email'
                    ]
                ]
            ],
            'Test validation' =>
            [
                'payload' => [],
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'structureResponse' => [
                    'errors' => [
                        'name',
                        'email'
                    ]
                ]
            ]
        ];
   }

   public function testFind(): void
   {
        $user = User::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$user->email}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email'
            ]
        ]);
   }

   public function testFindNotFound(): void
   {
        $response = $this->getJson("{$this->endpoint}/fake_email");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
   }

    /**
     * @dataProvider dataProviderUpdateUser
     */
   public function testUpdate(array $payload, int $statusCode): void
   {
        $user = User::factory()->create();

        $response = $this->putJson("{$this->endpoint}/{$user->email}", $payload);
        $response->assertStatus($statusCode);
   }


    public function dataProviderUpdateUser(): array
    {
        return [
            'Test update with correct data' =>
            [
                'payload' => [
                    'name' => 'New User Test to Update',
                    'password' => 'NewPassword'
                ],
                'statusCode' => Response::HTTP_OK,
                'structureResponse' => [
                    'data' => [
                        'id',
                        'name',
                        'password'
                    ]
                ]
            ],
            'Test Update with Validation' =>
            [
                'payload' => [
                    'password' => 'pass_generation'
                ],
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'structureResponse' => [
                    'errors' => [
                        'name',
                        'password'
                    ]
                ]
            ],
            'Test Update Empty Payload' =>
            [
                'payload' => [],
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'structureResponse' => [
                    'errors' => [
                        'name',
                        'password'
                    ]
                ]
            ]
        ];
    }


   public function testUpdateNotFound(): void
   {
        $response = $this->putJson("{$this->endpoint}/fake@mail.dev", [
            'name' => 'Pelif Elnida'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
   }

   public function testDelete(): void
   {
        $user = User::factory()->create();
        $response = $this->deleteJson("{$this->endpoint}/{$user->email}");
        $response->assertStatus(Response::HTTP_NO_CONTENT);
   }

   public function testDeleteNotFound(): void
   {
        $response = $this->deleteJson("{$this->endpoint}/fake@mail.dev");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
   }


}
