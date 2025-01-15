<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Assure-toi d'importer cette classe
use Illuminate\Notifications\Notifiable;

class School extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'schoolName',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'school';
}
