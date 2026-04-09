<?php

declare(strict_types=1);

namespace App\Domain\Repository;

/**
 * @template T of object
 */
interface BaseRepository
{
    /**
     * @return T[]
     */
    public function findAll(): array;
    /**
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @param string $order
     * @param string|null $filterField
     * @param string|null $filterValue
     * @return T[]
     */
    public function findAllByPage(
        int $page = 1,
        int $limit = 10,
        string $orderBy = 'id',
        string $order = 'ASC',
        ?string $filterField = null,
        ?string $filterValue = null,
    ): array;
    /**
     * @param string $id
     * @return T|null
     */
    public function findById(string $id): ?object;
    /**
     * @param T $entity
     * @return void
     */
    public function save(object $entity): void;
    /**
     * @param T $entity
     * @return void
     */
    public function remove(object $entity): void;
}
