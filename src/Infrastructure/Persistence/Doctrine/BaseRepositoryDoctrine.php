<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Repository\BaseRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @template T of object
 * @implements BaseRepository<T>
 * @extends ServiceEntityRepository<T>
 */
abstract class BaseRepositoryDoctrine extends ServiceEntityRepository implements BaseRepository
{
    protected EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
        $this->entityManager = $this->getEntityManager();
    }

    /**
     * @return array<int, T>
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<int, T>
     */
    public function findAllByPage(
        int $page = 1,
        int $limit = 10,
        string $orderBy = 'id',
        string $order = 'ASC',
        ?string $filterField = null,
        ?string $filterValue = null,
    ): array {
        $qb = $this->createQueryBuilder('p');
        if (!empty($filterValue) && !empty($filterField)) {
            $qb->andWhere('LOWER(p.' . $filterField . ') LIKE LOWER(:filterValue)')
                ->setParameter('filterValue', '%' . $filterValue . '%');
        }
        return $qb->orderBy('p.' . $orderBy, $order)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return T|null
     */
    public function findById(string $id): ?object
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param T $entity
     */
    public function save(object $entity): void
    {
        $this->entityManager->persist($entity);
    }

    /**
     * @param T $entity
     */
    public function remove(object $entity): void
    {
        $this->entityManager->remove($entity);
    }

}
