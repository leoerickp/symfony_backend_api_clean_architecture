<?php

declare(strict_types=1);

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

}
