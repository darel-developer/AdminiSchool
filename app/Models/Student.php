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
    ];

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class_id');
    }
}
