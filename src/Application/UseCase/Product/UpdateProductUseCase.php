<?php

declare(strict_types=1);

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;
use App\Domain\Entity\Product;
use App\Application\Exception\NotFoundException;
use App\Application\ValueObject\ProductValueObject;

class UpdateProductUseCase
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    /**
     * @param string $id
     * @param ProductValueObject $productValueObject
     * @throws NotFoundException
     * @return Product
     */
    public function execute(string $id, ProductValueObject $productValueObject): Product
    {
        $product = $this->productRepository->findById($id);
        if (!$product) {
            throw new NotFoundException(sprintf('Product with ID "%s" not found', $id));
        }

        $product->update($productValueObject);

        $this->productRepository->save($product);
        return $product;
    }
}
