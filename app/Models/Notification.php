<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuteur_id',
        'message',
        'url', // Ajout de la colonne `url` dans les champs remplissables
        'created_at', // Ajout du champ created_at
    ];

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class);
    }

    public function getUrlAttribute()
    {
        // Exemple : rediriger vers la page des paiements si le message contient "paiement"
        if (str_contains($this->message, 'paiement')) {
            return route('parentpaiement');
        }

        // Ajouter d'autres conditions pour d'autres types de notifications
        if (str_contains($this->message, 'document')) {
            return route('parentdocument');
        }

        if (str_contains($this->message, 'chat')) {
            return route('parentchat');
        }

        // Par défaut, rediriger vers le tableau de bord
        return route('parent');
    }
}
