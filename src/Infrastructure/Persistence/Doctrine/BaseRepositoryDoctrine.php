<?php

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

    public function findAll(): array
    {
        try {
            //code...
            return $this->createQueryBuilder('p')
                ->orderBy('p.id', 'ASC')
                ->getQuery()
                ->getResult();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

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

    public function findById(string $id): ?object
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(object $entity, bool $flush = true): void
    {
        $this->entityManager->persist($entity);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function remove(object $entity, bool $flush = true): void
    {
        $this->entityManager->remove($entity);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

}
