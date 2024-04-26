<?php

namespace Tests\Feature\App\Repository\Eloquent;

use App\Models\User;
use Tests\TestCase;
use App\Repository\Contracts\UserRepositoryInterface;
use App\Repository\Eloquent\UserRepository;


class UserRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        $this->repository = new UserRepository(new User());
        parent::setUp();
    }

    public function testImplementsInterface(): void
    {
        $this->assertInstanceOf(
            UserRepositoryInterface::class,
            new UserRepository(new User())
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFindAllEmpty()
    {
        $response = $this->repository->findAll();

        $this->assertIsArray($response);
        $this->assertCount(0, $response);
    }

    public function testFindAll(): void
    {
        user::factory()->count(10)->create();

        $response = $this->repository->findAll();

        $this->assertIsArray($response);
        $this->assertCount(10, $response);
    }
}
