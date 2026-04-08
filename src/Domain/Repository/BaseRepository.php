<?php

namespace App\Domain\Repository;

interface BaseRepository
{
    public function findAll(): array;
    public function findById(string $id): ?object;

    public function save(object $entity, bool $flush = true): void;
    public function remove(object $entity, bool $flush = true): void;

}
