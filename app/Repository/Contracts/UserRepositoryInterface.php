<?php

namespace App\Repository\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findAll(): array;
    public function paginate(int $page = 1): PaginationInterface;
    // public function paginate(int $page = 1): PaginationInterface;
    public function create(array $data): object;
    public function getModel(): User;
    public function update(string $email, array $data): object;
    public function delete(string $email): bool;
    public function find(string $email): object;
}
