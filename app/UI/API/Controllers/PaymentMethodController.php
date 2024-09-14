<?php

namespace App\UI\API\Controllers;

use App\Application\Services\PaymentMethod\PaymentMethodService;
use App\Domain\Models\PaymentMethod\Enum\PaymentDriverEnum;
use App\Domain\Models\PaymentMethod\Resource\PaymentMethodResource;
use App\Infrastructure\Repository\PaymentMethod\PaymentMethodCrudContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

readonly class PaymentMethodController
{
    public function __construct(private PaymentMethodService $paymentMethodService)
    {
    }

    public function index(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $methods = $this->paymentMethodService->index();
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return PaymentMethodResource::collection($methods);
    }

    public function redirectPayment(string $payment_uuid): JsonResponse|RedirectResponse
    {
        // Получаем класс нужного драйвера исходя из выбранного метода оплаты
        try {
            $payment_driver_class = $this->paymentMethodService->getDriver($payment_uuid);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        // Создаем платеж в выбранной системе
        try {
            $payment = $payment_driver_class->createPayment($payment_uuid);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        // Редирект на страницу оплаты выбранного метода оплаты
        try {
            $data = $payment_driver_class->redirect($payment);
            return response()->json(['data' => $data], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
