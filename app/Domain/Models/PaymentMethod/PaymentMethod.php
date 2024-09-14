<?php

namespace App\Domain\Models\PaymentMethod;

use App\Domain\Models\Currency\Currency;
use App\Domain\Models\PaymentMethod\Enum\PaymentDriverEnum;
use Database\Factories\PaymentMethodFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name,
 * @property PaymentDriverEnum $driver,
 * @property bool $active,
 * @property string $currency_id
 */
class PaymentMethod extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'active',
        'driver',
        'currency_id'
    ];

    protected $casts = [
        'active' => 'boolean',
        'driver' => PaymentDriverEnum::class,
    ];

    protected static function newFactory(): PaymentMethodFactory
    {
        return PaymentMethodFactory::new();
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
