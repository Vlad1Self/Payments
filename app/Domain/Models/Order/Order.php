<?php

namespace App\Domain\Models\Order;

use App\Domain\Models\Currency\Currency;
use App\Domain\Models\Order\ValueObject\Price;
use App\Domain\Models\Payable\Enum\PayableStatusEnum;
use App\Domain\Models\User\User;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid,
 * @property string $price,
 * @property string $status,
 * @property integer $user_id,
 * @property integer $currency_id
 */
class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'currency_id',
        'price',
        'status',
    ];

    protected $casts = [
        'status' => PayableStatusEnum::class,
    ];

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(function ($order) {
            $order->uuid = Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
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

}
