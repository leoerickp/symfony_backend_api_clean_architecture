<?php

declare(strict_types=1);

namespace App\Domain\Security;

use App\Domain\Entity\User;

interface TokenGenerator
{
    public function generate(User $user): string;
}
