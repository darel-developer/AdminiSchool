<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuteur_id',
        'file_path',
    ];

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class);
    }
}
