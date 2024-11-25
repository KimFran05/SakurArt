<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_utilizator',
        'nume',
        'prenume',
        'numartelefon',
        'adresa',
        'judet',
        'localitate',
        'total',
        'produse',
    ];

    protected $casts = [
        'produse' => 'json'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_utilizator');
    }

    public function product() {
        return $this->hasMany(Product::class, 'id_produs');
    }

    public function categories() {
        return $this->belongsTo(Category::class, 'id_categorie');
    }
}
