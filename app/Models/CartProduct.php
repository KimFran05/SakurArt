<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_utilizator',
        'id_produs',
        'name',
        'pret',
        'cantitate',
        'image',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'id_produs');
    }
}
