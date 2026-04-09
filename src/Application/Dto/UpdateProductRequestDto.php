<?php

declare(strict_types=1);

namespace App\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateProductRequestDto
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    public ?string $title = null;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'numeric')]
    public string|float|int $price = '0';

    #[Assert\NotBlank]
    public ?string $description = null;

    #[Assert\NotBlank]
    public ?string $slug = null;

    #[Assert\Type(type: 'integer')]
    public int $stock = 0;

    #[Assert\NotBlank]
    public ?string $gender = null;

    /**
     * @var string[]|null
     */
    #[Assert\Type(type: 'array')]
    #[Assert\All([
        new Assert\Type(type: 'string')
    ])]
    public ?array $sizes = null;

    /**
     * @var string[]|null
     */
    #[Assert\Type(type: 'array')]
    #[Assert\All([
        new Assert\Type(type: 'string')
    ])]
    public ?array $tags = null;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return static
     */
    public function setTitle(?string $title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string|float|int $price
     * @return static
     */
    public function setPrice(string|float|int $price): static
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return static
     */
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return static
     */
    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     * @return static
     */
    public function setStock(int $stock): static
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     * @return static
     */
    public function setGender(?string $gender): static
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getSizes(): ?array
    {
        return $this->sizes;
    }

    /**
     * @param string[]|null $sizes
     * @return static
     */
    public function setSizes(?array $sizes): static
    {
        $this->sizes = $sizes;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @param string[]|null $tags
     * @return static
     */
    public function setTags(?array $tags): static
    {
        $this->tags = $tags;
        return $this;
    }
}
