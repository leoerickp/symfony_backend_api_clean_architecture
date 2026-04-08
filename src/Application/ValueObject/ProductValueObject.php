<?php

namespace App\Application\ValueObject;

class ProductValueObject
{
    /**
     * Summary of __construct
     * @param string $title
     * @param float $price
     * @param string $description
     * @param string $slug
     * @param int $stock
     * @param string $gender
     * @param string[] $sizes
     * @param string[] $tags
     */
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
