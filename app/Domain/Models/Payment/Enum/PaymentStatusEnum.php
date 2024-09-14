<?php declare(strict_types=1);

namespace App\Domain\Models\Payment\Enum;

use BenSampo\Enum\Enum;

final class PaymentStatusEnum extends Enum
{
    const pending = 'pending';
    const processing = 'processing';
    const success = 'success';
    const failed = 'failed';

    public function label(): string
    {
        return match ($this->value) {
            self::pending => 'Ожидает оплаты',
            self::processing => 'В процессе оплаты',
            self::success => 'Оплачен',
            self::failed => 'Произошла ошибка',
        };
    }
}
