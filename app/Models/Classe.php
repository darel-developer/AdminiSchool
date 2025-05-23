<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class', 'name'); 
    }

    public function teachers()
{
    return $this->hasMany(Teacher::class, 'class_id', 'id'); 
}
}
