<?php

namespace App\Domain\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Domain\Models\User\ValueObject\Email;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $name,
 * @property Email $email,
 * @property string $password
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function email(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: function($value) {
                $email = new Email($value);
                return $email->getValue();
            },
        );
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return ucwords($value);
            },
            set: function($value) {
                return strtolower($value);
            },
        );
    }
}
