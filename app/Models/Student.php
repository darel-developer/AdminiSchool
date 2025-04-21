<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'class', // Assurez-vous que cette colonne existe dans la table `students`
        'enrollment_date',
        'absences',
        'convocations',
        'warnings',
    ];

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class);
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
