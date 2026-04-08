<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Domain\Entity\Product;
use App\Domain\Entity\ProductImage;
use App\Domain\Entity\User;
use App\Domain\Security\PasswordHasher;
use App\Data\UserData;
use App\Data\ProductData;

class AppFixtures extends Fixture
{
    public function __construct(
        private PasswordHasher $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $products = ProductData::get();

        $users = UserData::get();

        foreach ($users as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setFullName($data['fullName']);
            $user->setPassword($this->passwordHasher->hash($data['password']));
            $user->setRoles($data['roles']);
            $manager->persist($user);
        }

        foreach ($products as $data) {
            $product = new Product();

            $product->setTitle($data['title']);
            $product->setPrice($data['price']);
            $product->setDescription($data['description']);
            $product->setSlug($data['slug']);
            $product->setStock($data['stock']);
            $product->setSizes($data['sizes']);
            $product->setTags($data['tags']);
            $product->setGender($data['gender']);

            $manager->persist($product);

            foreach ($data['images'] as $img) {
                $image = new ProductImage();
                $image->setUrl($img);

                $image->setProduct($product);

                $manager->persist($image);
            }
        }

        $manager->flush();
    }
}
