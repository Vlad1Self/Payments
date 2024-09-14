<?php

namespace App\Application\Services\Payment\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class GetPaymentMethodDTO extends DataTransferObject
{
    public int $payment_method_id;
}
