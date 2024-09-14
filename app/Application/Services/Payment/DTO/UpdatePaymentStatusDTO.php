<?php

namespace App\Application\Services\Payment\DTO;

use App\Domain\Models\Payment\Payment;
use Spatie\DataTransferObject\DataTransferObject;

class UpdatePaymentStatusDTO extends DataTransferObject
{
    public Payment $payment;
    public string $status;
}
