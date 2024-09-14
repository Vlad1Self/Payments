<?php

namespace App\Application\Services\Payment\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class IndexPaymentDTO extends DataTransferObject
{
    public int $page;
}
