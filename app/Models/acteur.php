<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acteur extends Model
{
    protected $fillable = [
        'firstName',
        'secondName',
        'childName',
        'schoolName', 
        'username',
        'password',
    ];

    protected $table = 'acteur'; // Nom de la table
}
