<?php

declare(strict_types=1);

namespace App\Application\ValueObject;

class ProductValueObject
{
    /**
     * @param string $title
     * @param float $price
     * @param string $description
     * @param string $slug
     * @param int $stock
     * @param string $gender
     * @param string[] $sizes
     * @param string[] $tags
     * @param string[] $images
     */
    public function __construct(
        public string $title,
        public float $price,
        public string $description,
        public string $slug,
        public int $stock,
        public string $gender,
        public array $sizes,
        public array $tags,
        public array $images
    ) {
    }
}
