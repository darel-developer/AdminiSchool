<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\CahierDeTexte;

class CahierDeTexteImport implements ToModel
{
    public function model(array $row)
    {
        // Traitez chaque ligne du fichier Excel ici
        return new CahierDeTexte([
            'nom_fichier' => $row[0], // Exemple de colonne
            'chemin_fichier' => $row[1], // Exemple de colonne
        ]);
    }
}
