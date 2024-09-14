<?php

namespace App\UI\API\Controllers;

use App\Application\Services\Payment\DTO\ChoosePaymentMethodDTO;
use App\Application\Services\Payment\DTO\CompletePaymentDTO;
use App\Application\Services\Payment\DTO\IndexPaymentDTO;
use App\Application\Services\Payment\DTO\ShowPaymentDTO;
use App\Application\Services\Payment\PaymentService;
use App\Domain\Models\Payment\Payment;
use App\Domain\Models\Payment\Resource\PaymentResource;
use App\UI\API\Requests\Payment\ChoosePaymentMethodRequest;
use App\UI\API\Requests\Payment\CompletePaymentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

readonly class PaymentController
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function index(int $page): AnonymousResourceCollection|JsonResponse
    {
        $data = new IndexPaymentDTO(['page' => $page]);

        try {
            $payments = $this->paymentService->index($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return PaymentResource::collection($payments);
    }

    public function checkout(string $uuid): PaymentResource|JsonResponse
    {
        $data = new ShowPaymentDTO(['uuid' => $uuid]);

        try {
            $payment = $this->paymentService->checkout($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return new PaymentResource($payment);
    }

    public function choosePaymentMethod(ChoosePaymentMethodRequest $request, string $uuid): JsonResponse|RedirectResponse
    {
        $data = new ChoosePaymentMethodDTO(['payment_uuid' => $uuid, 'payment_method_id' => $request->validated('payment_method_id')]);

        try {
            $update_payment = $this->paymentService->choosePaymentMethod($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return redirect()->to('api/payments/process/' . $update_payment->uuid);
    }

    public function process(string $uuid): JsonResponse|RedirectResponse
    {
        $data = new ShowPaymentDTO(['uuid' => $uuid]);

        try {
            $payment = $this->paymentService->process($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return response()->redirectTo('api/payment_methods/' . $payment->uuid . '/redirectPayment');
    }

    public function success(string $uuid): JsonResponse
    {
        return response()->json(['data' => 'Платеж успешно завершен. Ожидайте изменения в БД']);
    }

    public function failure(string $uuid): JsonResponse
    {
        return response()->json(['data' => 'Платеж отменен. Ожидайте изменения в БД']);
    }
}
