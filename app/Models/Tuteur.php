<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tuteur extends Model
{
    protected $table = 'tuteurs';  // Spécifier la table

    protected $fillable = [
        'firstName', 'lastName', 'childName', 'schoolName', 'username', 'password'
    ];
}
