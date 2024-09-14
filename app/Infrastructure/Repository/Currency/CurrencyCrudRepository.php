<?php

namespace App\Infrastructure\Repository\Currency;

use App\Domain\Models\Currency\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrencyCrudRepository implements CurrencyCrudContract
{

    public function index(): Collection
    {
        return Currency::query()->get();
    }
}
