<?php declare(strict_types=1);

namespace App\Domain\Models\Payment\Enum;

use BenSampo\Enum\Enum;

final class PaymentPayableEnum extends Enum
{
    const order = 'order';

    const subscription = 'subscription';
}
