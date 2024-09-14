<?php

namespace App\Application\Services\User\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class IndexUserDTO extends DataTransferObject
{
    public int $page;
}
