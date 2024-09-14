<?php

namespace App\UI\API\Controllers;

use App\Application\Services\Subscription\DTO\IndexSubscriptionDTO;
use App\Application\Services\Subscription\DTO\ShowSubscriptionDTO;
use App\Application\Services\Subscription\SubscriptionService;
use App\Domain\Models\Subscription\Resource\SubscriptionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

readonly class SubscriptionController
{
    public function __construct(private SubscriptionService $subscriptionService)
    {
    }

    public function index(int $page): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexSubscriptionDTO(['page' => $page]);

        try {
            $subscriptions = $this->subscriptionService->index($data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return SubscriptionResource::collection($subscriptions);
    }

    public function show(string $uuid): JsonResponse
    {
        try {
            $subscription = $this->subscriptionService->show(new ShowSubscriptionDTO(['uuid' => $uuid]));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return response()->json(new SubscriptionResource($subscription));
    }

    public function payment(Request $request, string $uuid): JsonResponse|RedirectResponse
    {
        $data = new ShowSubscriptionDTO(['uuid' => $uuid]);

        try {
            $payment = $this->subscriptionService->payment($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        return redirect()->to('api/payments/checkout/' . $payment->uuid);
    }
}
