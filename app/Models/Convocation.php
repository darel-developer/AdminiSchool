<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Convocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'reason',
    ];
}