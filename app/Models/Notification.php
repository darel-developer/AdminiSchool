<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuteur_id',
        'message',
    ];

    /**
     * Relation avec le modèle Tuteur.
     */
    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class);
    }
}
