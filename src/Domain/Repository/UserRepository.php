<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Repository\BaseRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends BaseRepository<User>
 */
interface UserRepository extends BaseRepository, PasswordUpgraderInterface
{
    /**
     * Summary of upgradePassword
     * @param PasswordAuthenticatedUserInterface $user
     * @param string $newHashedPassword
     * @return void
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void;

    /**
     * Summary of findOneByEmail
     * @param string $email
     * @return User|null
     */
    public function findOneByEmail(string $email): ?User;

}
