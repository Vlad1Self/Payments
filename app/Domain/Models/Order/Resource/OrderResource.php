<?php

namespace App\Domain\Models\Order\Resource;

use App\Domain\Models\Currency\Resource\CurrencyResource;
use App\Domain\Models\User\Resource\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'user' => new UserResource($this->user),
            'currency' => new CurrencyResource($this->currency),
            'price' => $this->price,
            'status' => $this->status->label(),
        ];
    }
}
