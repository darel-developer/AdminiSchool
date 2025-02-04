<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'typepaiement',
        'montant',
        'num_facture',
        'etat',
        
    ];
}
