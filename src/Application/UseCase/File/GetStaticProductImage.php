<?php

declare(strict_types=1);

namespace App\Application\UseCase\File;


use App\Application\Exception\BadRequestException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GetStaticProductImage
{
    private string $projectDir;
    public function __construct(
        ParameterBagInterface $params
    ) {
        $this->projectDir = $params->get('kernel.project_dir');
    }

    public function execute(string $imageName): string
    {
        $path = $this->projectDir . '/src/static/products/' . $imageName;

        if (!file_exists($path)) {
            throw new BadRequestException("No product found with image $imageName");
        }

        return $path;
    }
}
