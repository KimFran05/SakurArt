<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_utilizator',
        'id_produs',
        'rating',
        'titlu',
        'continut',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_utilizator');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'id_produs');
    }
}
