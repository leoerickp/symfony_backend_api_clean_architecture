<?php

namespace App\Infrastructure\Http\Resolver;

use App\Infrastructure\Http\Exception\ValidationException;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDtoResolver implements ValueResolverInterface
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();

        if (!$type || !class_exists($type)) {
            return [];
        }

        if (!str_starts_with($type, 'App\\Application\\Dto\\')) {
            return [];
        }

        $data = json_decode($request->getContent(), true);

        $dto = new $type();

        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if (method_exists($dto, $setter)) {
                $dto->$setter($value);
            }
        }

        // 🔥 VALIDACIÓN AQUÍ
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $formattedErrors = [];

            foreach ($errors as $error) {
                $formattedErrors[] = [
                    'field' => $error->getPropertyPath(),
                    'message' => $error->getMessage(),
                ];
            }

            throw new ValidationException($formattedErrors);
            // throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException(
            //     json_encode($formattedErrors)
            // );
        }

        yield $dto;
    }
}
