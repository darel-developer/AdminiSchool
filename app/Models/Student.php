<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'class', 
        'enrollment_date',
        'absences',
        'convocations',
        'warnings',
        'tuteur_id', // Ajout de la colonne tuteur_id
    ];

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class, 'tuteur_id'); // Adjust the foreign key if necessary
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class', 'name');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'class_id', 'class_Name');
    }

    public function notes()
    {
        return $this->hasMany(Grades::class, 'student_name', 'name');
    }
}
