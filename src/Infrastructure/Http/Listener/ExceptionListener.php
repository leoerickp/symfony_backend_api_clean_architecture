<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Listener;

use App\Application\Exception\ValidationException;
use App\Application\Exception\NotFoundException;
use App\Domain\Enum\ApiErrorCode;
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
                ApiErrorCode::NOT_FOUND->value,
                [$exception->getMessage()],
                ApiErrorCode::NOT_FOUND->getHttpStatusCode()
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
                ApiErrorCode::DUPLICATE_ENTRY->value,
                [
                    'message' => 'This record already exists'
                ],
                ApiErrorCode::DUPLICATE_ENTRY->getHttpStatusCode()
            ));
            return;
        }

        // FOREIGN KEY ERROR
        if ($exception instanceof ForeignKeyConstraintViolationException) {
            $event->setResponse(new ErrorResponse(
                ApiErrorCode::FOREIGN_KEY_ERROR->value,
                [
                    'message' => 'Cannot delete or update because it is linked to other records'
                ],
                ApiErrorCode::FOREIGN_KEY_ERROR->getHttpStatusCode()
            ));
            return;
        }

        // GENERIC DB ERROR
        if ($exception instanceof \Doctrine\DBAL\Exception) {
            $event->setResponse(new ErrorResponse(
                ApiErrorCode::DATABASE_ERROR->value,
                [],
                ApiErrorCode::DATABASE_ERROR->getHttpStatusCode()
            ));
            return;
        }


        // fallback general
        $event->setResponse(new ErrorResponse(
            ApiErrorCode::INTERNAL_SERVER_ERROR->value,
            [$exception->getMessage()],
            ApiErrorCode::INTERNAL_SERVER_ERROR->getHttpStatusCode()
        ));
    }

    private function getMessage(int $statusCode): string
    {
        return match ($statusCode) {
            ApiErrorCode::UNAUTHORIZED->getHttpStatusCode() => ApiErrorCode::UNAUTHORIZED->value,
            ApiErrorCode::FORBIDDEN->getHttpStatusCode() => ApiErrorCode::FORBIDDEN->value,
            ApiErrorCode::NOT_FOUND->getHttpStatusCode() => ApiErrorCode::NOT_FOUND->value,
            default => 'HTTP_ERROR',
        };
    }
}
