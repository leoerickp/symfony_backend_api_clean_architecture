<?php

namespace App\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateProductRequestDto
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

    /**
     * Summary of sizes
     * @var string[]|null
     */
    #[Assert\Type(type: 'array')]
    #[Assert\All([
        new Assert\Type(type: 'string')
    ])]
    public ?array $sizes = null;

    /**
     * Summary of sizes
     * @var string[]|null
     */
    #[Assert\Type(type: 'array')]
    #[Assert\All([
        new Assert\Type(type: 'string')
    ])]
    public ?array $tags = null;

    /**
     * Summary of getTitle
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Summary of setTitle
     * @param string|null $title
     * @return self
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Summary of getPrice
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * Summary of setPrice
     * @param string $price
     * @return self
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Summary of getDescription
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Summary of setDescription
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Summary of getSlug
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Summary of setSlug
     * @param string|null $slug
     * @return self
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Summary of getStock
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * Summary of setStock
     * @param int $stock
     * @return self
     */
    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * Summary of getGender
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * Summary of setGender
     * @param string|null $gender
     * @return self
     */
    public function setGender(?string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * Summary of getSizes
     * @return string[]|null
     */
    public function getSizes(): ?array
    {
        return $this->sizes;
    }

    /**
     * Summary of setSizes
     * @param string[]|null $sizes
     * @return self
     */
    public function setSizes(?array $sizes): self
    {
        $this->sizes = $sizes;
        return $this;
    }

    /**
     * Summary of getTags
     * @return string[]|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * Summary of setTags
     * @param string[]|null $tags
     * @return self
     */
    public function setTags(?array $tags): self
    {
        $this->tags = $tags;
        return $this;
    }
}
