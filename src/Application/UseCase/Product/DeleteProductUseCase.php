<?php

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;
use App\Application\Exception\NotFoundException;
use App\Domain\Entity\Product;


class DeleteProductUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    /**
     * Summary of execute
     * @param string $id
     * @throws NotFoundException
     * @return Product
     */
    public function execute(string $id): ?Product
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            throw new NotFoundException('Product not found');
        }
        $this->productRepository->remove($product, true);
        return $product;
    }
}
