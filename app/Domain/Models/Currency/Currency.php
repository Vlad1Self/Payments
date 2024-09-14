<?php

namespace App\Domain\Models\Currency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id,
 * @property string $name
 */
class Currency extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];
}
