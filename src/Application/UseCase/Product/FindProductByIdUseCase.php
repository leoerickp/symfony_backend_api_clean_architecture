<?php

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;
use App\Application\Exception\NotFoundException;

class FindProductByIdUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    public function execute(string $id): ?object
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            throw new NotFoundException('Product not found');
        }
        return $product;
    }
}
