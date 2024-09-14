<?php

namespace App\Domain\Models\Payment;

use App\Domain\Models\Currency\Currency;
use App\Domain\Models\Payment\Enum\PaymentStatusEnum;
use App\Domain\Models\Payment\ValueObject\Amount;
use App\Domain\Models\PaymentMethod\PaymentMethod;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

/**
 * @property string $uuid,
 * @property PaymentStatusEnum $status,
 * @property string $currency_id,
 * @property string $amount,
 * @property int $payable_id,
 * @property string $driver_payment_id,
 * @property string $payable_type,
 * @property int $payment_method_id
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'currency_id',
        'amount',
        'payable_id',
        'driver_payment_id',
        'payable_type',
        'payment_method_id',
    ];

    protected $casts = [
        'status' => PaymentStatusEnum::class,
    ];

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: function($value) {
                $price = new Amount($value);
                return $price->getValue();
            },
        );
    }

    protected static function booted(): void
    {
        static::creating(function ($payment) {
            $payment->uuid = Str::uuid();
        });
    }

    protected static function newFactory(): PaymentFactory
    {
        return PaymentFactory::new();
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }
}
