<?php

namespace App\Application\Services\Order\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class StoreOrderDTO extends DataTransferObject
{
    public string $currency_id;
    public int $user_id;
    public string $price;
}
