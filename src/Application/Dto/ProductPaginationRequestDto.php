<?php

declare(strict_types=1);

namespace App\Application\Dto;

final readonly class ProductPaginationRequestDto
{
    public function __construct(
        public int $page = 1,
        public int $limit = 10,
        public string $orderBy = 'id',
        public string $order = 'ASC',
        public string $filterField = '',
        public string $filterValue = ''
    ) {
    }
}
