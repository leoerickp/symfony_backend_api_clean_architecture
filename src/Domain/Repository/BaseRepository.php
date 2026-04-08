<?php

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
     * Summary of findAllByPage
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
     * Summary of findById
     * @param string $id
     * @return T|null
     */
    public function findById(string $id): ?object;
    /**
     * Summary of save
     * @param T $entity
     * @param bool $flush
     * @return void
     */
    public function save(object $entity, bool $flush = true): void;
    /**
     * Summary of remove
     * @param T $entity
     * @param bool $flush
     * @return void
     */
    public function remove(object $entity, bool $flush = true): void;

}
