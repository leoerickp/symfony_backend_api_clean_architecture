<?php

namespace App\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateProductRequestDto
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    public ?string $title = null;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'numeric')]
    public string $price = '0';

    #[Assert\NotBlank]
    public ?string $description = null;

    #[Assert\NotBlank]
    public ?string $slug = null;

    #[Assert\Type(type: 'integer')]
    public int $stock = 0;

    #[Assert\NotBlank]
    public ?string $gender = null;

    #[Assert\Type(type: 'array')]
    public ?array $sizes = null;

    #[Assert\Type(type: 'array')]
    public ?array $tags = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getSizes(): ?array
    {
        return $this->sizes;
    }

    public function setSizes(?array $sizes): self
    {
        $this->sizes = $sizes;
        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;
        return $this;
    }
}
