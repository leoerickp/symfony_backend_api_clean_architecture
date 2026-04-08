<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\Product\FindAllProductsUseCase;
use App\Application\UseCase\Product\FindProductByIdUseCase;
use App\Infrastructure\Http\Response\SuccessResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//#[IsGranted('ROLE_USER')]
final class ProductController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private readonly FindAllProductsUseCase $findAllProductsUseCase,
        private readonly FindProductByIdUseCase $findByIdProductUseCase
    ) {
    }

    #[Route('/api/products', name: 'app_product', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getAllProducts(): JsonResponse
    {
        $products = $this->findAllProductsUseCase->execute();
        return new SuccessResponse($this->serializer, $products);
    }

    #[Route('/api/products/{id}', name: 'app_product_id', methods: ['GET'])]
    public function getProductById(string $id): JsonResponse
    {
        $product = $this->findByIdProductUseCase->execute($id);
        return new SuccessResponse($this->serializer, $product);
    }
}
