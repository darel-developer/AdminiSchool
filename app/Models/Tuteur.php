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
        'phone_number',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'name', 'childname');
    }
    


    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    protected $guard = 'tuteur';
}
