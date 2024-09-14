<?php

namespace App\Application\Services\Payment\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ShowPaymentDTO extends DataTransferObject
{
    public string $uuid;
}
