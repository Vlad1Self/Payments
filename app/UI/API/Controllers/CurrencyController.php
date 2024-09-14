<?php

namespace App\UI\API\Controllers;

use App\Application\Services\Currency\CurrencyService;
use App\Domain\Models\Currency\Resource\CurrencyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

readonly class CurrencyController
{
    public function __construct(private CurrencyService $currencyService)
    {
    }

    public function index(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $currencies = $this->currencyService->index();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return CurrencyResource::collection($currencies);
    }
}
