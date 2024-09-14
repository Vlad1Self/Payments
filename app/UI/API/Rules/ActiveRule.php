<?php

namespace App\UI\API\Rules;

use App\Domain\Models\PaymentMethod\PaymentMethod;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ActiveRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $payment_method = PaymentMethod::query()->find($value);

        if (!$payment_method->active) {
            $fail('The selected payment method is not active.');
        }
    }
}
