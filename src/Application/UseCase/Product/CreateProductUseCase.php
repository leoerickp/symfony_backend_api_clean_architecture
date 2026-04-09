<?php

declare(strict_types=1);

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;
use App\Domain\Entity\Product;
use App\Domain\Entity\User;
use App\Domain\Repository\UnitOfWork;
use App\Application\ValueObject\ProductValueObject;

class CreateProductUseCase
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly UnitOfWork $unitOfWork
    ) {
    }

    /**
     * @param ProductValueObject $productValueObject
     * @return Product
     */
    public function execute(ProductValueObject $productValueObject, User $user): Product
    {
        $product = Product::create($productValueObject, $user);

        $this->productRepository->save($product);
        $this->unitOfWork->flush();
        return $product;
    }
}
