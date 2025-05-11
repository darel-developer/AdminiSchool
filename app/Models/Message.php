<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages'; // Specify the table name

    protected $fillable = [
        'message',
        'teacher_id',
        'tuteur_id',
        'student_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
