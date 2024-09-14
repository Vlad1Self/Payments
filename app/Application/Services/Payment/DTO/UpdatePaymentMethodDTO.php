<?php

namespace App\Application\Services\Payment\DTO;

use App\Domain\Models\Payment\Payment;
use Spatie\DataTransferObject\DataTransferObject;

class UpdatePaymentMethodDTO extends DataTransferObject
{
    public string $payment_method_id;
    public Payment $payment;
}
