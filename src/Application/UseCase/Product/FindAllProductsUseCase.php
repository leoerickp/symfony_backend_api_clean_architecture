<?php

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;

class FindAllProductsUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    public function execute(): array
    {
        return $this->productRepository->findAll();
    }
}
