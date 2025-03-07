<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    // public function all(): \Illuminate\Database\Eloquent\Collection;

    public function register(array $data): array;

    public function login(array $data): array;

    public function logout(): array;

    // public function update(array $data, int $id): int;

    // public function delete(int $id): bool;

    public function find(int $id): array;
}