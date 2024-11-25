<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'prenume',
        'email',
        'password',
        'functie',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reviews() {
        return $this->hasMany(Review::class, 'id_utilizator');
    }

    public function favorites() {
        return $this->hasMany(Favorite::class, 'id_utilizator');
    }

    public function cart_products() {
        return $this->hasMany(CartProduct::class, 'id_utilizator');
    }

    public function orders() {
        return $this->hasMany(Order::class, 'id_utilizator');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->functie === 'ADMIN';
    }
}
