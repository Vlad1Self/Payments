<?php

namespace App\Application\Services\Order\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ShowOrderDTO extends DataTransferObject
{
    public string $uuid;
}
