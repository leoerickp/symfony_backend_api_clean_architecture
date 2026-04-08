<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\ProductImage;
use App\Domain\Repository\ProductImageRepository;
use App\Infrastructure\Persistence\Doctrine\BaseRepositoryDoctrine;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepositoryDoctrine<ProductImage>
 */
class ProductImageRepositoryDoctrine extends BaseRepositoryDoctrine implements ProductImageRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductImage::class);
    }

    //    /**
//     * @return ProductImage[] Returns an array of ProductImage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    //    public function findOneBySomeField($value): ?ProductImage
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
