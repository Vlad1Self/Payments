<?php

namespace App\Application\Services\Payment\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ChoosePaymentMethodDTO extends DataTransferObject
{
    public string $payment_uuid;
    public string $payment_method_id;
}
