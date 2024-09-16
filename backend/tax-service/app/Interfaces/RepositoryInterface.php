<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function getAll(): array;

    public function getById(int $id): ?object;

    public function create(object $entity): bool;

    public function update(int $id, object $entity): bool;

    public function delete(int $id): bool;
}
