<?php

namespace App\Domain\Models\Order\ValueObject;

use InvalidArgumentException;

class Price
{
    private string $value;
    public function __construct($value)
    {
        if (is_numeric($value)) {
            $this->value = $value;
        } else {
            throw new InvalidArgumentException('Price must be numeric');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
