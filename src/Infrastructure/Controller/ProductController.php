<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Dto\CreateProductRequestDto;
use App\Application\Mapper\ProductMapper;
use App\Application\UseCase\Product\CreateProductUseCase;
use App\Application\UseCase\Product\FindAllProductsUseCase;
use App\Application\UseCase\Product\FindAllProductsByPageUseCase;
use App\Application\UseCase\Product\FindProductByIdUseCase;
use App\Application\UseCase\Product\DeleteProductUseCase;
use App\Application\UseCase\Product\UpdateProductUseCase;
use App\Application\Dto\ProductPaginationRequestDto;
use App\Application\Dto\UpdateProductRequestDto;
use App\Infrastructure\Http\Response\SuccessResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;

final class ProductController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly FindAllProductsUseCase $findAllProductsUseCase,
        private readonly FindAllProductsByPageUseCase $findAllProductsByPageUseCase,
        private readonly FindProductByIdUseCase $findByIdProductUseCase,
        private readonly CreateProductUseCase $createProductUseCase,
        private readonly UpdateProductUseCase $updateProductUseCase,
        private readonly DeleteProductUseCase $deleteProductUseCase,

    ) {
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/api/products', name: 'app_product', methods: ['GET'])]
    public function getAllProducts(): JsonResponse
    {
        $products = $this->findAllProductsUseCase->execute();
        return new SuccessResponse($this->serializer, $products);
    }

    #[Route('/api/products/by-page', name: 'app_product_by_page', methods: ['GET'])]
    public function getAllProductsByPage(Request $request): JsonResponse
    {
        $dto = new ProductPaginationRequestDto(
            max(1, (int) $request->query->get('page', 1)),
            min(100, max(1, (int) $request->query->get('limit', 10))),
            $request->query->get('orderBy', 'id'),
            $request->query->get('order', 'ASC'),
            $request->query->get('filterField', ''),
            $request->query->get('filterValue', '')
        );

        $products = $this->findAllProductsByPageUseCase->execute(
            $dto->page,
            $dto->limit,
            $dto->orderBy,
            $dto->order,
            $dto->filterField,
            $dto->filterValue
        );
        return new SuccessResponse($this->serializer, $products);
    }

    #[Route('/api/products/{id}', name: 'app_product_id', methods: ['GET'])]
    public function getProductById(string $id): JsonResponse
    {
        $product = $this->findByIdProductUseCase->execute($id);
        return new SuccessResponse($this->serializer, $product);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/api/products', name: 'app_product_create', methods: ['POST'])]
    public function createProduct(CreateProductRequestDto $createProductRequestDto): JsonResponse
    {
        $user = $this->getUser();
        $product = $this->createProductUseCase->execute(ProductMapper::CreateDtoToValueObject($createProductRequestDto), $user);
        return new SuccessResponse($this->serializer, $product);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/api/products/{id}', name: 'app_product_update', methods: ['PUT'])]
    public function updateProduct(string $id, UpdateProductRequestDto $updateProductRequestDto): JsonResponse
    {
        $product = $this->updateProductUseCase->execute($id, ProductMapper::UpdateDtoToValueObject($updateProductRequestDto));
        return new SuccessResponse($this->serializer, $product);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/api/products/{id}', name: 'app_product_delete', methods: ['DELETE'])]
    public function deleteProduct(string $id): JsonResponse
    {
        $this->deleteProductUseCase->execute($id);
        return new SuccessResponse($this->serializer, \sprintf('Product with ID "%s" deleted successfully', $id));
    }
}
