<?php declare(strict_types=1);

namespace App\Domain\Models\Payable\Enum;

use BenSampo\Enum\Enum;


final class PayableStatusEnum extends Enum
{
    public const new = 'new';
    public const completed = 'completed';

    public function label(): string
    {
        return match ($this->value) {
            self::new => 'Создан',
            self::completed => 'Завершен',
        };
    }
}
