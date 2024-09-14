<?php

namespace App\Domain\Models\Payment\ValueObject;

use InvalidArgumentException;

class Amount
{
    private string $value;
    public function __construct($value)
    {
        if (is_numeric($value)) {
            $this->value = $value;
        } else {
            throw new InvalidArgumentException('Amount must be numeric');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
