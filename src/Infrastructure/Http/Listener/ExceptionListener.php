<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Listener;

use App\Application\Exception\ValidationException;
use App\Application\Exception\NotFoundException;
use App\Infrastructure\Http\Response\ErrorResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidationException) {
            $event->setResponse(new ErrorResponse(
                $exception->getMessage(),
                $exception->errors,
                Response::HTTP_BAD_REQUEST
            ));
            return;
        }

        if ($exception instanceof NotFoundException) {
            $event->setResponse(new ErrorResponse(
                'NOT_FOUND',
                [$exception->getMessage()],
                Response::HTTP_NOT_FOUND
            ));
            return;
        }

        // HTTP exceptions
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
            $event->setResponse(new ErrorResponse(
                $this->getMessage($exception->getStatusCode()),
                [$exception->getMessage()],
                $exception->getStatusCode()
            ));
            return;
        }

        // DUPLICATE ENTRY (UNIQUE constraint)
        if ($exception instanceof UniqueConstraintViolationException) {
            $event->setResponse(new ErrorResponse(
                'DUPLICATE_RESOURCE',
                [
                    'message' => 'This record already exists'
                ],
                409
            ));
            return;
        }

        // FOREIGN KEY ERROR
        if ($exception instanceof ForeignKeyConstraintViolationException) {
            $event->setResponse(new ErrorResponse(
                'FOREIGN_KEY_ERROR',
                [
                    'message' => 'Cannot delete or update because it is linked to other records'
                ],
                409
            ));
            return;
        }

        // GENERIC DB ERROR
        if ($exception instanceof \Doctrine\DBAL\Exception) {
            $event->setResponse(new ErrorResponse(
                'DATABASE_ERROR',
                [],
                500
            ));
            return;
        }


        // fallback general
        $event->setResponse(new ErrorResponse(
            'INTERNAL_SERVER_ERROR',
            [$exception->getMessage()],
            500
        ));
    }

    private function getMessage(int $statusCode): string
    {
        return match ($statusCode) {
            401 => 'UNAUTHORIZED',
            403 => 'FORBIDDEN',
            404 => 'RESOURCE_NOT_FOUND',
            default => 'HTTP_ERROR',
        };
    }
}
