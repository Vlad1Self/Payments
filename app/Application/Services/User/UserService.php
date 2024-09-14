<?php

namespace App\Application\Services\User;

use App\Application\Services\User\DTO\IndexUserDTO;
use App\Application\Services\User\DTO\ShowUserDTO;
use App\Domain\Models\User\User;
use App\Infrastructure\Repository\User\UserCrudContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

readonly class UserService
{
    public function __construct(private UserCrudContract $userRepository)
    {

    }

    public function index(IndexUserDTO $data): LengthAwarePaginator
    {
        try {
            return $this->userRepository->index($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function show(ShowUserDTO $data): User
    {
        try {
            return $this->userRepository->show($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
}
