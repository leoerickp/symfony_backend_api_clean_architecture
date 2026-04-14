<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\UseCase\File\GetStaticProductImage;
use App\Application\Exception\BadRequestException;
use App\Infrastructure\Http\Response\SuccessResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class FilesController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly GetStaticProductImage $getStaticProductImage
    ) {
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/api/files/product', name: 'app_files_product', methods: ['POST'])]
    public function uploadProductImage(Request $request): JsonResponse
    {
        $file = $request->files->get('file');
        if (!$file) {
            throw new BadRequestException('No file provided');
        }

        // Validate MIME type (equivalent to fileFilter)
        if (!str_starts_with($file->getMimeType(), 'image/')) {
            throw new BadRequestException('File must be an image');
        }

        // Validate file size (equivalent to fileSize)
        if ($file->getSize() > 1024 * 1024 * 5) {
            throw new BadRequestException('File must be less than 5MB');
        }

        // Generate unique name (equivalent to fileNamer)
        $fileName = uniqid() . '.' . $file->guessExtension();

        try {
            $file->move(
                $this->getParameter('kernel.project_dir') . '/src/static/products/',
                $fileName
            );
        } catch (\Throwable $th) {
            throw new \Exception('Error uploading file');
        }

        // Public URL
        $secureUrl = $request->getSchemeAndHttpHost() . '/api/files/product/' . $fileName;

        return new SuccessResponse($this->serializer, [
            'url' => $secureUrl
        ]);
    }

    #[Route('/api/files/product/{imageName}', name: 'app_files_product_image', methods: ['GET'])]
    public function getProductImage(string $imageName): BinaryFileResponse
    {
        $imageName = basename($imageName);
        $imagePath = $this->getStaticProductImage->execute($imageName);
        return (new BinaryFileResponse($imagePath))->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
