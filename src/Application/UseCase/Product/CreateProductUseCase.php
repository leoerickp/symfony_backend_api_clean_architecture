<?php

declare(strict_types=1);

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;
use App\Domain\Entity\Product;
use App\Application\ValueObject\ProductValueObject;

class CreateProductUseCase
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    /**
     * @param ProductValueObject $productValueObject
     * @return Product
     */
    public function execute(ProductValueObject $productValueObject): Product
    {
        $product = Product::create($productValueObject);

        $this->productRepository->save($product);
        return $product;
    }
}
