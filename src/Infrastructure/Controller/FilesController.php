<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\UseCase\File\GetStaticProductImage;
use App\Infrastructure\Http\Response\SuccessResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class FilesController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly GetStaticProductImage $getStaticProductImage
    ) {
    }

    #[Route('/api/files/upload', name: 'app_files_upload', methods: ['POST'])]
    public function upload(): JsonResponse
    {

        return new SuccessResponse($this->serializer);
    }

    #[Route('/api/files/product/{imageName}', name: 'app_files_product_image', methods: ['GET'])]
    public function getProductImage(string $imageName): BinaryFileResponse
    {
        $imageName = basename($imageName);
        $imagePath = $this->getStaticProductImage->execute($imageName);
        return (new BinaryFileResponse($imagePath))->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
