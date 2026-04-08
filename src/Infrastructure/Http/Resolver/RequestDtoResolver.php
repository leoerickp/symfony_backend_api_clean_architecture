<?php

namespace App\Infrastructure\Http\Resolver;

use App\Application\Exception\ValidationException;
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

    /**
     * Summary of resolve
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @throws ValidationException
     * @return iterable<object>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();

        if (!$type || !class_exists($type)) {
            return [];
        }

        if (!str_starts_with($type, 'App\\Application\\Dto\\')) {
            return [];
        }

        $content = $request->getContent();

        if (empty($content)) {
            throw new ValidationException(['body: Request body is empty']);
        }

        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ValidationException(['body: Invalid JSON: ' . json_last_error_msg()]);
        }

        $dto = new $type();

        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if (method_exists($dto, $setter)) {
                $dto->$setter($value);
            }
        }

        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $formattedErrors = [];

            foreach ($errors as $error) {
                $formattedErrors[] = (string) $error->getPropertyPath() . ': ' . (string) $error->getMessage();
            }

            throw new ValidationException($formattedErrors);
        }

        yield $dto;
    }
}
