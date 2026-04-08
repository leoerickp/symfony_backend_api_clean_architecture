<?php
namespace App\Service;

use App\Domain\Repository\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }
    public function findAllProducts()
    {
        return $this->productRepository->findAll();
    }
}
