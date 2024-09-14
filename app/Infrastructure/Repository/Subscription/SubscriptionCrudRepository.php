<?php

namespace App\Infrastructure\Repository\Subscription;

use App\Application\Services\Subscription\DTO\IndexSubscriptionDTO;
use App\Domain\Models\Payment\Enum\PaymentPayableEnum;
use App\Domain\Models\Payment\Enum\PaymentStatusEnum;
use App\Domain\Models\Payment\Payment;
use App\Domain\Models\Subscription\Subscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubscriptionCrudRepository implements SubscriptionCrudContract
{

    public function index(IndexSubscriptionDTO $data): LengthAwarePaginator
    {
        return Subscription::query()->paginate(10, ['*'], 'page', $data->page);
    }

    public function show(string $uuid): Subscription
    {
        $subscription = Subscription::query()->with(['currency', 'user'])->where('uuid', $uuid)->first();

        if (!$subscription) {
            throw new \Exception('Subscription not found');
        }
        return $subscription;
    }

    public function store_payment(Subscription $subscription): bool|Payment
    {
        $payment = new Payment;

        $payment->currency_id = $subscription->currency_id;
        $payment->status = PaymentStatusEnum::pending;
        $payment->amount = $subscription->price * env('COMMISSION', 1);
        $payment->payable_id = $subscription->id;
        $payment->payable_type = PaymentPayableEnum::subscription;

        if ($payment->save()){
            return $payment;
        } else {
            throw new \Exception('Payment not created');
        }
    }
}
