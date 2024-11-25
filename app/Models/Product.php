<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_categorie',
        'nume',
        'producator',
        'pret',
        'descriere',
        'image',
        'file',
    ];

    public function reviews() {
        return $this->hasMany(Review::class, 'id_produs');
    }

    public function categories() {
        return $this->belongsTo(Category::class, 'id_categorie');
    }
}
