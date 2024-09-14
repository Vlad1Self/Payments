<?php

namespace App\Domain\Models\Subscription;

use App\Domain\Models\Currency\Currency;
use App\Domain\Models\Order\ValueObject\Price;
use App\Domain\Models\Payable\Enum\PayableStatusEnum;
use App\Domain\Models\User\User;
use Database\Factories\SubscriptionFactory;
use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property int $id,
 * @property string $uuid,
 * @property string $price,
 * @property string $currency_id,
 * @property string $user_id,
 * @property PayableStatusEnum $status,
 * @property DateTime $startedAt,
 * @property DateTime $expiredAt
 */
class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'currency_id',
        'user_id',
        'status',
        'startedAt',
        'expiredAt',
    ];

    protected $casts =[
        'status' => PayableStatusEnum::class,
        'startedAt' => 'datetime',
        'expiredAt' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($subscription) {
            $subscription->uuid = Str::uuid();
        });
    }

    protected static function newFactory(): SubscriptionFactory
    {
        return SubscriptionFactory::new();
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: function($value) {
                $price = new Price($value);
                return $price->getValue();
            },
        );
    }

    protected function startedAt(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                return $value;
            },
            set: function($value) {
                return new DateTime($value);
            },
        );
    }

    protected function expiredAt(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                return $value;
            },
            set: function($value) {
                return new DateTime($value);
            },
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
