<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;


// Pastikan class 'implements MustVerifyEmail'
class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    use HasFactory;
    use Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id', // Untuk Google Login
        'phone_number',
        'email_verified_at',
        'address',
    ];

    /**
     * Atribut yang harus disembunyikan (tidak ditampilkan saat di-JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Penting untuk membedakan admin
        ];
    }

    /**
     * Relasi: Satu User memiliki banyak Order (pesanan).
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    public function canAccessPanel(Panel $panel): bool
    {
        // Cek apakah panel yang diakses adalah 'admin'
        // dan user memiliki kolom 'is_admin' == true
        if ($panel->getId() === 'admin') {
            return $this->is_admin;
        }

        return false; // Blokir akses ke panel lain (jika ada)
    }
}
