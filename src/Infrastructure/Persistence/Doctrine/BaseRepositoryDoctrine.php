<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Repository\BaseRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @template T of object
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
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
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
