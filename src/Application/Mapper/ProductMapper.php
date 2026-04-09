<?php

declare(strict_types=1);

namespace App\Application\Mapper;

use App\Application\Dto\CreateProductRequestDto;
use App\Application\Dto\UpdateProductRequestDto;
use App\Application\ValueObject\ProductValueObject;

class ProductMapper
{
    public static function CreateDtoToValueObject(CreateProductRequestDto $dto): ProductValueObject
    {
        return new ProductValueObject(
            $dto->title,
            (float) $dto->price,
            $dto->description,
            $dto->slug,
            $dto->stock,
            $dto->gender,
            $dto->sizes,
            $dto->tags
        );
    }
    public static function UpdateDtoToValueObject(UpdateProductRequestDto $dto): ProductValueObject
    {
        return new ProductValueObject(
            $dto->title,
            (float) $dto->price,
            $dto->description,
            $dto->slug,
            $dto->stock,
            $dto->gender,
            $dto->sizes,
            $dto->tags
        );
    }
}
