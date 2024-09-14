<?php

namespace App\Application\Services\Payment\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class UpdatePayableStatusDTO extends DataTransferObject
{
    public string $payable_type;

    public int $payable_id;

    public string $status;
}
