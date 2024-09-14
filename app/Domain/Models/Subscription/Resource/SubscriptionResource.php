<?php

namespace App\Domain\Models\Subscription\Resource;

use App\Domain\Models\Currency\Resource\CurrencyResource;
use App\Domain\Models\User\Resource\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user' => new UserResource($this->user),
            'currency' => new CurrencyResource($this->currency),
            'status' => $this->status->label(),
            'startedAt' => $this->startedAt,
            'expiredAt' => $this->expiredAt,
        ];
    }
}
