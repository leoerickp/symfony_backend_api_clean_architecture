<?php

declare(strict_types=1);

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;
use App\Domain\Repository\UnitOfWork;
use App\Application\Exception\NotFoundException;


class DeleteProductUseCase
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly UnitOfWork $unitOfWork
    ) {
    }

    /**
     * @param string $id
     * @throws NotFoundException
     * @return void
     */
    public function execute(string $id): void
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            throw new NotFoundException(sprintf('Product with ID "%s" not found', $id));
        }
        $this->productRepository->remove($product);
        $this->unitOfWork->flush();
    }
}
