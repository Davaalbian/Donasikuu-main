<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\DataDonasi;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'no_telp',
        'jenis_kelamin',
        'alamat',
        'rt',
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
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDonatur(): bool
    {
        return $this->role === 'donatur';
    }

    public function isVerified(): bool
    {
        if ($this->isAdmin()) return true;

        return !is_null($this->email_verified_at);
    }

    public function donasi()
    {
        return $this->hasMany(DataDonasi::class, 'user_id');
    }
}