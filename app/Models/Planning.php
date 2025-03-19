<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

    protected $fillable = [
        'class',
        'date',
        'start_time',
        'end_time',
        'code',
        'teacher',
        'room',
    ];
}