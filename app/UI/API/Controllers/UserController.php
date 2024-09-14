<?php

namespace App\UI\API\Controllers;

use App\Application\Services\User\DTO\IndexUserDTO;
use App\Application\Services\User\DTO\ShowUserDTO;
use App\Application\Services\User\UserService;
use App\Domain\Models\User\Resource\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

readonly class UserController
{
    public function __construct(private UserService $userService)
    {
    }

    public function index(int $page): AnonymousResourceCollection|JsonResponse
    {
        $data = new IndexUserDTO(['page' => $page]);

        try {
            $users = $this->userService->index($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return UserResource::collection($users);
    }


    public function show(int $id): JsonResponse|UserResource
    {
        try {
            $user = $this->userService->show(new ShowUserDTO(['id' => $id]));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return new UserResource($user);
    }


}
