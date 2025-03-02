<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $fillable = [
        'nume',
        'prenume',
        'email',
        'data_nasterii',
        'semnatura',
        'semnatura_mana',
    ];
}
