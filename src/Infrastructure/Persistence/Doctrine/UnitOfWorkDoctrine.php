<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Repository\UnitOfWork;
use Doctrine\ORM\EntityManagerInterface;

class UnitOfWorkDoctrine implements UnitOfWork
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function beginTransaction(): void
    {
        $this->entityManager->beginTransaction();
    }

    public function commit(): void
    {
        try {
            $this->entityManager->commit();
        } catch (\Throwable $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    public function rollback(): void
    {
        $this->entityManager->rollback();
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
