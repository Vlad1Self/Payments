<?php

namespace App\Domain\Models\Payment\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status->label(),
            'payable' => $this->payable,
            'payment_method' => $this->paymentMethod
        ];
    }
}
