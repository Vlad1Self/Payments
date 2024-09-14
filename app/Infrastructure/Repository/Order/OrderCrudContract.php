<?php

namespace App\Infrastructure\Repository\Order;

use App\Application\Services\Order\DTO\IndexOrderDTO;
use App\Application\Services\Order\DTO\SearchOrderDTO;
use App\Application\Services\Order\DTO\StoreOrderDTO;
use App\Domain\Models\Order\Order;
use App\Domain\Models\Payment\Payment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderCrudContract
{
    public function index(IndexOrderDTO $data): LengthAwarePaginator;

    public function show(string $uuid): Order;

    public function store(StoreOrderDTO $data): bool;

    public function find(SearchOrderDTO $data): int;

    public function store_payment(Order $order): bool|Payment;
}
