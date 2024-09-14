<?php

namespace App\Application\Services\Subscription;

use App\Application\Services\Subscription\DTO\IndexSubscriptionDTO;
use App\Application\Services\Subscription\DTO\ShowSubscriptionDTO;
use App\Domain\Models\Payable\Enum\PayableStatusEnum;
use App\Domain\Models\Payment\Payment;
use App\Domain\Models\Subscription\Subscription;
use App\Infrastructure\Repository\Subscription\SubscriptionCrudContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

readonly class SubscriptionService
{
    public function __construct(private SubscriptionCrudContract $subscriptionRepository)
    {
    }

    public function index(IndexSubscriptionDTO $data): LengthAwarePaginator
    {
        try {
            return $this->subscriptionRepository->index($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function show(ShowSubscriptionDTO $data): Subscription
    {
        try {
            return $this->subscriptionRepository->show($data->uuid);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function payment(ShowSubscriptionDTO $data): Payment
    {
        try {
            $subscription = $this->subscriptionRepository->show($data->uuid);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }

        if ($subscription->status != PayableStatusEnum::new) {
            throw new \Exception('Subscription is not new');
        }

        try {
            $payment = $this->subscriptionRepository->store_payment($subscription);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }

        return $payment;
    }
}
