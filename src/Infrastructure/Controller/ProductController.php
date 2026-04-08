<?php

namespace App\Infrastructure\Controller;

use App\Infrastructure\Http\Response\SuccessResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ProductService;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//#[IsGranted('ROLE_USER')]
final class ProductController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ProductService $productService,
    ) {
    }

    #[Route('/api/products', name: 'app_product', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function getAllProducts(): JsonResponse
    {
        $products = $this->productService->findAllProducts();
        return new SuccessResponse($this->serializer, $products);
    }
}
