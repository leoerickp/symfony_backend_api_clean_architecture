<?php

declare(strict_types=1);

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;
use App\Application\Exception\NotFoundException;
use App\Domain\Entity\Product;

class FindProductByIdUseCase
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    /**
     * @param string $id
     * @throws NotFoundException
     * @return Product
     */
    public function execute(string $id): ?Product
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            throw new NotFoundException(sprintf('Product with ID "%s" not found', $id));
        }
        return $product;
    }
}
