<?php

namespace App\Infrastructure\Repository\Order;

use App\Application\Services\Order\DTO\IndexOrderDTO;
use App\Application\Services\Order\DTO\SearchOrderDTO;
use App\Application\Services\Order\DTO\StoreOrderDTO;
use App\Domain\Models\Order\Order;
use App\Domain\Models\Payment\Enum\PaymentPayableEnum;
use App\Domain\Models\Payment\Enum\PaymentStatusEnum;
use App\Domain\Models\Payment\Payment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderCrudRepository implements OrderCrudContract
{

    public function index(IndexOrderDTO $data): LengthAwarePaginator
    {
        return Order::query()->with(['currency', 'user'])->paginate(10, ['*'], 'page', $data->page);
    }

    public function show(string $uuid): Order
    {
        $order = Order::query()->with(['currency', 'user'])->where('uuid', $uuid)->first();

        if (!$order) {
            throw new \Exception('Order not found');
        }
        return $order;
    }

    public function store(StoreOrderDTO $data): bool
    {
        $order = new Order();
        $order->currency_id = $data->currency_id;
        $order->price = $data->price;
        $order->user_id = $data->user_id;
        return $order->save();
    }

    public function find(SearchOrderDTO $data): int
    {
        return Order::query()->whereBetween('price', [$data->min_price, $data->max_price])->count();
    }

    public function store_payment(Order $order): bool|Payment
    {
        $payment = new Payment;

        $payment->currency_id = $order->currency_id;
        $payment->status = PaymentStatusEnum::pending;
        $payment->amount = $order->price * env('COMMISSION', 1);
        $payment->payable_id = $order->id;
        $payment->payable_type = PaymentPayableEnum::order;
        if ($payment->save()){
            return $payment;
        } else {
            throw new \Exception('Payment not created');
        }
    }
}
