<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'kasir_id');
    }

    public function penggunaanBahans()
    {
        return $this->hasMany(PenggunaanBahan::class);
    }

    public function artikels()
    {
        return $this->hasMany(Artikel::class, 'author_id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Accessors
    public function getIsSuperadminAttribute()
    {
        return $this->role === 'superadmin';
    }

    public function getIsKasirAttribute()
    {
        return $this->role === 'kasir';
    }
}