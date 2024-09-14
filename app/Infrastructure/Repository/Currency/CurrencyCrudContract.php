<?php

namespace App\Infrastructure\Repository\Currency;

use Illuminate\Database\Eloquent\Collection;

interface CurrencyCrudContract
{
    public function index(): Collection;
}
