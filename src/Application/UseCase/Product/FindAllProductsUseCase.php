<?php

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;
use App\Domain\Entity\Product;

class FindAllProductsUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    /**
     * @return list<Product>
     */
    public function execute(): array
    {
        return $this->productRepository->findAll();
    }
}
