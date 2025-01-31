<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Tuteur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'type',
        'password',
        'child_name',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'name', 'childname');
    }

    protected $guard = 'tuteur';
}
