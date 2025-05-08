<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CahierDeTextesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('cahier_de_textes')->insert([
            [
                'id' => 1,
                'date' => '2025-04-20',
                'matiere' => 'SVT',
                'contenu' => 'La Révolution française',
                'professeur' => 'Mlle Durand',
                'devoirs' => 'Préparer une présentation',
                'class' => '3ème',
                'created_at' => '2025-04-21 16:38:07',
                'updated_at' => '2025-04-21 16:38:07',
            ],
            [
                'id' => 2,
                'date' => '2025-04-01',
                'matiere' => 'Physique-Chimie',
                'contenu' => 'Les cellules',
                'professeur' => 'M. Martin',
                'devoirs' => 'Faire une rédaction',
                'class' => '5ème',
                'created_at' => '2025-04-21 16:38:07',
                'updated_at' => '2025-04-21 16:38:07',
            ],
            // ...ajoutez ici toutes les autres données de la table `cahier_de_textes`...
        ]);
    }
}
