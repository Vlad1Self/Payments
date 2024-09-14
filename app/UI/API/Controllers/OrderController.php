<?php

namespace App\UI\API\Controllers;

use App\Application\Services\Order\DTO\IndexOrderDTO;
use App\Application\Services\Order\DTO\SearchOrderDTO;
use App\Application\Services\Order\DTO\ShowOrderDTO;
use App\Application\Services\Order\DTO\StoreOrderDTO;
use App\Application\Services\Order\OrderService;
use App\Domain\Models\Order\Resource\OrderResource;
use App\Domain\Models\Payment\Resource\PaymentResource;
use App\UI\API\Requests\Order\FindOrderRequest;
use App\UI\API\Requests\Order\StoreOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

readonly class OrderController
{
    public function __construct(private OrderService $service)
    {
    }

    public function index(int $page): JsonResponse
    {
        try {
           $orders = $this->service->index(new IndexOrderDTO(['page' => $page]));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return response()->json(OrderResource::collection($orders));
    }

    public function show(string $uuid): JsonResponse
    {
        try {
            $order = $this->service->show(new ShowOrderDTO(['uuid' => $uuid]));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return response()->json(new OrderResource($order));
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $status = $this->service->store(new StoreOrderDTO($request->validated()));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return response()->json(['status' => $status]);
    }

    public function find(FindOrderRequest $request): JsonResponse
    {
        try {
            $count = $this->service->find(new SearchOrderDTO($request->validated()));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return response()->json(['count' => $count]);
    }

    public function payment(Request $request, string $uuid): JsonResponse|RedirectResponse
    {
        $data = new ShowOrderDTO(['uuid' => $uuid]);

        try {
            $payment = $this->service->payment($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        return redirect()->to('api/payments/checkout/' . $payment->uuid);
    }
}
