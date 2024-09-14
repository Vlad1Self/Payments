<?php declare(strict_types=1);

namespace App\Domain\Models\PaymentMethod\Enum;

use BenSampo\Enum\Enum;


final class PaymentDriverEnum extends Enum
{
    public const test = 'test';
    public const paypal = 'paypal';
    public const stripe = 'stripe';

    public function label()
    {
        return match ($this->value) {
            self::test => 'Тестовый способ оплаты',
            self::paypal => 'Paypal',
            self::stripe => 'Stripe',
        };
    }
}
