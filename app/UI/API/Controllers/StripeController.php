<?php

namespace App\UI\API\Controllers;

use App\Application\Services\Payment\DTO\ShowPaymentDTO;
use App\Application\Services\Payment\PaymentService;
use App\Domain\Models\Payment\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Stripe;
use Stripe\Webhook;

readonly class StripeController
{
    public function __construct(private PaymentService $service)
    {
    }

    public function callback(Request $request): JsonResponse
    {
        Stripe::setApiKey(config()->get('services.stripe.secret_key'));

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('stripe-signature'),
                config()->get('services.stripe.webhook_secret')
            );
        } catch(SignatureVerificationException|UnexpectedValueException $e) {
            Log::error($e->getMessage());
            return response()->json();
        }

        $payment_uuid = $event->data->object->metadata->payment_uuid;

        match ($event->type) {
            'payment_intent.succeeded' => $this->service->success(new ShowPaymentDTO(['uuid' => $payment_uuid])),
            'payment_intent.payment_failed' => $this->service->failure(new ShowPaymentDTO(['uuid' => $payment_uuid])),
            default => Log::error('Unhandled event type: ' . $event->type),
        };

         return response()->json();
    }
}
