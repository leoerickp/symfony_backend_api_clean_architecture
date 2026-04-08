<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Repository\BaseRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

interface UserRepository extends BaseRepository, PasswordUpgraderInterface
{
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void;

    public function findOneByEmail(string $email): ?User;

}
