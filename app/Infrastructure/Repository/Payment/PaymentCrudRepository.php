<?php

namespace App\Infrastructure\Repository\Payment;

use App\Application\Services\Payment\DTO\ChoosePaymentMethodDTO;
use App\Application\Services\Payment\DTO\GetPaymentMethodDTO;
use App\Application\Services\Payment\DTO\IndexPaymentDTO;
use App\Application\Services\Payment\DTO\ShowPaymentDTO;
use App\Application\Services\Payment\DTO\UpdatePayableStatusDTO;
use App\Application\Services\Payment\DTO\UpdatePaymentMethodDTO;
use App\Application\Services\Payment\DTO\UpdatePaymentStatusDTO;
use App\Domain\Models\Order\Order;
use App\Domain\Models\Payment\Payment;
use App\Domain\Models\PaymentMethod\Enum\PaymentDriverEnum;
use App\Domain\Models\PaymentMethod\PaymentMethod;
use App\Domain\Models\Subscription\Subscription;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentCrudRepository implements PaymentCrudContract
{
    public function index(IndexPaymentDTO $data): LengthAwarePaginator
    {
        return Payment::query()->paginate(10, ['*'], 'page', $data->page);
    }

    public function show(ShowPaymentDTO $data): Payment
    {
        $payment = Payment::query()->where('uuid', $data->uuid)->first();
        if (!$payment) {
            throw new \Exception('Payment not found');
        }

        return $payment;
    }

    public function getPaymentMethod(GetPaymentMethodDTO $data): PaymentMethod
    {
        return PaymentMethod::query()->find($data->payment_method_id);
    }

    public function updatePaymentMethod(UpdatePaymentMethodDTO $data): Payment
    {
        $data->payment->payment_method_id = $data->payment_method_id;

        $data->payment->save();

        return $data->payment;
    }

    public function updatePaymentStatus(UpdatePaymentStatusDTO $data): Payment
    {
        $data->payment->status = $data->status;

        $data->payment->save();

        return $data->payment;
    }

    public function updatePayableStatus(UpdatePayableStatusDTO $data): bool
    {
        if ($data->payable_type === "order") {
            $order = Order::query()->where('id', $data->payable_id)->first();

            $order->status = $data->status;

            return $order->save();
        } elseif ($data->payable_type === "subscription") {
            /** @var Subscription $subscription */
            $subscription = Subscription::query()->where('id', $data->payable_id)->first();

            $subscription->status = $data->status;
            $subscription->startedAt = now();
            $subscription->expiredAt = now()->addDays(30);

            return $subscription->save();
        } else {
            throw new \Exception('Payment has invalid payable type');
        }

    }
}
