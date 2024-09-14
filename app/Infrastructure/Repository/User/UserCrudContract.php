<?php

namespace App\Infrastructure\Repository\User;

use App\Application\Services\User\DTO\IndexUserDTO;
use App\Application\Services\User\DTO\ShowUserDTO;
use App\Domain\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserCrudContract
{
    public function index(IndexUserDTO $data): LengthAwarePaginator;

    public function show(ShowUserDTO $data): User;
}
