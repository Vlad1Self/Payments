<?php

namespace App\Infrastructure\Repository\PaymentMethod\Factory;

use App\Application\Services\PaymentMethod\Driver\PaymentDriver;
use App\Application\Services\PaymentMethod\Driver\StripeDriver;
use App\Application\Services\PaymentMethod\Driver\TestDriver;
use App\Domain\Models\PaymentMethod\Enum\PaymentDriverEnum;
use InvalidArgumentException;

class PaymentDriverFactory
{
    public function make(string $paymentDriver): PaymentDriver
    {
        return match ($paymentDriver) {
            PaymentDriverEnum::test => new TestDriver(),
            PaymentDriverEnum::stripe => new StripeDriver(),


            default => throw new InvalidArgumentException('Invalid payment method driver'),
        };
    }
}
