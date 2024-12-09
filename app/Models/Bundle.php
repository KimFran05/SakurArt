<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nume',
        'id_categorie',
        'produse',
        'pret',
        'descriere',
        'discount'
    ];

    protected $casts = [
        'produse' => 'json'
    ];

    public function product() {
        return $this->hasMany(Product::class, 'id_produs');
    }

    public function categories() {
        return $this->belongsTo(Category::class, 'id_categorie');
    }
}
