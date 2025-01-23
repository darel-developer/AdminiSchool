<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'tuteur_id',
        'school_id',
    ];

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
