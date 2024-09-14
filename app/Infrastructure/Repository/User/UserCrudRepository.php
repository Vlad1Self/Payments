<?php

namespace App\Infrastructure\Repository\User;

use App\Application\Services\User\DTO\IndexUserDTO;
use App\Application\Services\User\DTO\ShowUserDTO;
use App\Domain\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserCrudRepository implements UserCrudContract
{

    public function index(IndexUserDTO $data): LengthAwarePaginator
    {
        return User::query()->paginate(10, ['*'], 'page', $data->page);
    }

    public function show(ShowUserDTO $data): User
    {
        return User::query()->findOrFail($data->id);
    }
}
