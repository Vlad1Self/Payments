<?php

namespace App\Application\Services\PaymentMethod\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class RedirectPaymentDTO extends DataTransferObject
{
    public string $url;
    public string $payment_uuid;
    public string $driver_payment_uuid;
}
