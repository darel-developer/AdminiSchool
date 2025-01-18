<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    // Définir les attributs que l'on peut remplir
    protected $fillable = [
        'schoolName',
        'username',
        'password',
    ];

    // Si vous avez besoin de personnaliser le nom de la table (si elle ne suit pas la convention plurielle)
    protected $table = 'schools';
}
