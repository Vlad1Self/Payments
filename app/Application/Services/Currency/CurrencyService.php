<?php

namespace App\Application\Services\Currency;

use App\Infrastructure\Repository\Currency\CurrencyCrudContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

readonly class CurrencyService
{
    public function __construct(private CurrencyCrudContract $currencyCrudRepository)
    {
    }

    public function index(): Collection
    {
        try {
            return $this->currencyCrudRepository->index();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
