<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CahierDeTexte extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'matiere',
        'contenu',
        'professeur',
        'devoirs',
        'class',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
}
