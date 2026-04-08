<?php

namespace App\Application\ValueObject\Product;

class ProductValueObject
{
    public function __construct(
        public string $title,
        public float $price,
        public string $description,
        public string $slug,
        public int $stock,
        public string $gender,
        public array $sizes,
        public array $tags
    ) {
    }
}
