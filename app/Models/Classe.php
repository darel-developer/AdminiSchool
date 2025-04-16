<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Assurez-vous que cette colonne existe dans la table `classes`
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class', 'name'); // Utilisez 'class' comme clé étrangère
    }

    public function teachers()
{
    return $this->hasMany(Teacher::class, 'class_id', 'id'); // Utilisez 'class_id' comme clé étrangère
}
}
