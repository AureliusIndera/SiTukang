<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function mandor(): HasOne
    {
        return $this->hasOne(Mandor::class);
    }

    public function tukang(): HasOne
    {
        return $this->hasOne(Tukang::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMandor(): bool
    {
        return $this->role === 'mandor';
    }

    public function isTukang(): bool
    {
        return $this->role === 'tukang';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin'  => 'Administrator',
            'mandor' => 'Mandor',
            'tukang' => 'Tukang',
            default  => ucfirst($this->role),
        };
    }
}
