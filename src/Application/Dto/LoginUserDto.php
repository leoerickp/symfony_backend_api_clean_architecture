<?php

namespace App\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class LoginUserDto
{

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;
    #[Assert\NotBlank]
    #[Assert\Length(min: 6)]
    public string $password;

    /**
     * Summary of getEmail
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Summary of setEmail
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Summary of getPassword
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Summary of setPassword
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}
