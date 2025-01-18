<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Assurez-vous que vous importez cette classe
use Illuminate\Notifications\Notifiable;

class Schools extends Authenticatable // Changez de Model à Authenticatable
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

    protected $table = 'schools';
}