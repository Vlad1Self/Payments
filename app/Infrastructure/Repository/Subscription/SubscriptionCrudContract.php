<?php

namespace App\Infrastructure\Repository\Subscription;

use App\Application\Services\Subscription\DTO\IndexSubscriptionDTO;
use App\Domain\Models\Payment\Payment;
use App\Domain\Models\Subscription\Subscription;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SubscriptionCrudContract
{
    public function index(IndexSubscriptionDTO $data): LengthAwarePaginator;

    public function show(string $uuid): Subscription;

    public function store_payment(Subscription $subscription): bool|Payment;
}
