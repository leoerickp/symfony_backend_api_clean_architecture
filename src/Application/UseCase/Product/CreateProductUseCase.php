<?php

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;
use App\Domain\Entity\Product;
use App\Application\Exception\NotFoundException;
use App\Application\ValueObject\ProductValueObject;

class CreateProductUseCase
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    /**
     * Summary of execute
     * @param ProductValueObject $productValueObject
     * @return Product|null
     */
    public function execute(ProductValueObject $productValueObject): ?Product
    {
        $product = Product::create($productValueObject);

        $this->productRepository->save($product);
        return $product;
    }
}
