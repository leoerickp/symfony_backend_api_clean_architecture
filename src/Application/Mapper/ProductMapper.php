<?php

namespace App\Application\Mapper;

use App\Application\Dto\CreateProductRequestDto;
use App\Application\ValueObject\ProductValueObject;

class ProductMapper
{
    public static function toValueObject(CreateProductRequestDto $dto): ProductValueObject
    {
        return new ProductValueObject(
            $dto->title,
            $dto->price,
            $dto->description,
            $dto->slug,
            $dto->stock,
            $dto->gender,
            $dto->sizes,
            $dto->tags
        );
    }
}
