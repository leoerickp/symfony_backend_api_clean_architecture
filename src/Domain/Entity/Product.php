<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Base;
use App\Application\ValueObject\ProductValueObject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Product extends Base
{
    #[ORM\Column(length: 150)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private string $price = '0';

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column]
    private int $stock = 0;

    #[ORM\Column(length: 15)]
    private ?string $gender = null;

    /**
     * @var string[]
     */
    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $sizes = null;

    /**
     * @var string[]|null
     */
    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $tags = null;

    /**
     * @var Collection<int, ProductImage>
     */
    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $productImages;

    #[ORM\ManyToOne(inversedBy: 'products')]
    //#[MaxDepth(1)]
    private ?User $user = null;

    public function __construct()
    {
        parent::__construct();
        $this->productImages = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        if (!is_numeric($price)) {
            throw new \InvalidArgumentException('Invalid price');
        }
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
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
     * @param string[] $sizes
     * @return static
     */
    public function setSizes(array $sizes): static
    {
        $this->sizes = $sizes;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @param string[] $tags
     * @return static
     */
    public function setTags(array $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    /**
     * @param ProductImage $productImage
     * @return static
     */
    public function addProductImage(ProductImage $productImage): static
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages->add($productImage);
            $productImage->setProduct($this);
        }

        return $this;
    }

    /**
     * @param ProductImage $productImage
     * @return static
     */
    public function removeProductImage(ProductImage $productImage): static
    {
        if ($this->productImages->removeElement($productImage)) {
            // set the owning side to null (unless already changed)
            if ($productImage->getProduct() === $this) {
                $productImage->setProduct(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param ProductValueObject $productValueObject
     * @return static
     */
    public static function create(ProductValueObject $productValueObject, User $user): static
    {
        $product = new self();
        $product->update($productValueObject, $user);
        return $product;
    }

    /**
     * @param ProductValueObject $productValueObject
     * @return void
     */
    public function update(ProductValueObject $productValueObject, User $user)
    {
        $this->setTitle($productValueObject->title);
        $this->setPrice((string) $productValueObject->price);
        $this->setDescription($productValueObject->description);
        $this->setSlug($productValueObject->slug);
        $this->setStock($productValueObject->stock);
        $this->setGender($productValueObject->gender);
        $this->setSizes($productValueObject->sizes);
        $this->setTags($productValueObject->tags);
        $this->setUser($user);
    }
}
