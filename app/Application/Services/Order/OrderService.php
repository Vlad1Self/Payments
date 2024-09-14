<?php

namespace App\Application\Services\Order;

use App\Application\Services\Order\DTO\IndexOrderDTO;
use App\Application\Services\Order\DTO\SearchOrderDTO;
use App\Application\Services\Order\DTO\ShowOrderDTO;
use App\Application\Services\Order\DTO\StoreOrderDTO;
use App\Domain\Models\Order\Order;
use App\Domain\Models\Payable\Enum\PayableStatusEnum;
use App\Domain\Models\Payment\Payment;
use App\Infrastructure\Repository\Order\OrderCrudContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

readonly class OrderService
{
    public function __construct(private OrderCrudContract $orderRepository)
    {
    }

    public function index(IndexOrderDTO $data): LengthAwarePaginator
    {
        try {
            return $this->orderRepository->index($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function show(ShowOrderDTO $data): Order
    {
        try {
            return $this->orderRepository->show($data->uuid);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function store(StoreOrderDTO $data): bool
    {
        try {
            return $this->orderRepository->store($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function find(SearchOrderDTO $data): int
    {
        try {
            return $this->orderRepository->find($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function payment(ShowOrderDTO $data): Payment
    {
        try {
            $order = $this->orderRepository->show($data->uuid);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }

        if ($order->status != PayableStatusEnum::new) {
            throw new \Exception('Order is not new');
        }

        try {
            $payment = $this->orderRepository->store_payment($order);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }

        return $payment;
    }
}
