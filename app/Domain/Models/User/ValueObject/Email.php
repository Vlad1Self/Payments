<?php

namespace App\Domain\Models\User\ValueObject;

class Email
{
    private string $email;
    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email');
        } else {
            $this->email = $email;
        }
    }

    public function getValue(): string
    {
        return $this->email;
    }
}
