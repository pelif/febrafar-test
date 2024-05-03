<?php

namespace Tests\Feature\App\Repository\Eloquent;

use App\Models\User;
use Tests\TestCase;
use App\Repository\Contracts\UserRepositoryInterface;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Exceptions\NotFoundException;
use Exception;

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
        user::factory()->count(15)->create();

        $response = $this->repository->findAll();

        $this->assertIsArray($response);
        $this->assertCount(15, $response);
    }

    public function testCreate(): void
    {
        $data = [
            'name' => 'Pelif Elnida',
            'email' => 'pelif.elnida@test.com',
            'password' => bcrypt('123456')
        ];

        $response = $this->repository->create($data);

        $this->assertNotNull($response);

        $this->assertInstanceOf(
            User::class,
            $response
        );

        $this->assertDatabaseHas('users', [
            'email' => 'pelif.elnida@test.com'
        ]);
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'New Name'
        ];

        $response = $this->repository->update($user->email, $data);

        $this->assertIsObject($response);
        $this->assertDatabaseHas('users', ['name' => 'New Name']);
    }

    public function testDelete(): void
    {
        $user = User::factory()->create();

        $deleted = $this->repository->delete($user->email);

        $this->assertTrue($deleted);

        $this->assertDatabaseMissing('users', ['email' => $user->email]);
    }

    public function testDeleteNotFound(): void
    {
        $this->expectException(NotFoundException::class);

        $this->repository->delete('fake_email');
    }

    public function testFind(): void
    {
        $user = User::factory()->create();

        $finded = $this->repository->find($user->email);

        $this->assertIsObject($finded);
    }

    public function testFindNotFound(): void
    {
        $finded = $this->repository->find('fake mail');

        $this->assertNull($finded);
    }


}
