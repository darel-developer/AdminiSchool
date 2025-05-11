<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use Notifiable;

    protected $table = 'teachers'; // Specify the custom table name

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'subject',
        'type',
        'password',
        'class_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function students()
    {
        return $this->belongsTo(Student::class, 'class_id', 'class_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class_id', 'id');
    }
}

