<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepository;
use App\Infrastructure\Persistence\Doctrine\BaseRepositoryDoctrine;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepositoryDoctrine<Product>
 */
class ProductRepositoryDoctrine extends BaseRepositoryDoctrine implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

}
