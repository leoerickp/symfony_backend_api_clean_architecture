<?php

declare(strict_types=1);

namespace App\Domain\Repository;

interface UnitOfWork
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollback(): void;
    public function flush(): void;
}
