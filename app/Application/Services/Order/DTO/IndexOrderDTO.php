<?php

namespace App\Application\Services\Order\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class IndexOrderDTO extends DataTransferObject
{
    public int $page;
}
