<?php

namespace App;

use App\Validator\PasswordPolicy;
use Symfony\Component\Validator\Constraints as Assert;

class UserInputDto
{
    #[Assert\Email]
    private string $username;

    #[Assert\Length(min: 8)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[PasswordPolicy]private string $password;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}