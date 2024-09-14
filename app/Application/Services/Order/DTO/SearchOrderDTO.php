<?php

namespace App\Application\Services\Order\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class SearchOrderDTO extends DataTransferObject
{
    public string $min_price;

    public string $max_price;
}
