<?php

namespace App\Repositories\Contracts;

interface PostRepositoryInterface
{
    public function all(): array;

    public function create(array $data): array;

    public function update(array $data, int $id): array;

    public function delete(int $id): array;

    public function find(int $id): array;
}