<?php

namespace App\Application\UseCase\Product;

use App\Domain\Repository\ProductRepository;
use App\Domain\Entity\Product;

class FindAllProductsByPageUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    /**
     * Summary of execute
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @param string $order
     * @param string|null $filterField
     * @param string|null $filterValue
     * @return array<Product>
     */
    public function execute(
        int $page = 1,
        int $limit = 10,
        string $orderBy = 'id',
        string $order = 'ASC',
        ?string $filterField = null,
        ?string $filterValue = null
    ): array {
        return $this->productRepository->findAllByPage(
            $page,
            $limit,
            $orderBy,
            $order,
            $filterField,
            $filterValue
        );
    }
}
