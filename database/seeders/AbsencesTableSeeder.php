<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsencesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('absences')->insert([
            [
                'id' => 1,
                'student_name' => 'John Doe',
                'absence_date' => '2025-04-01',
                'reason' => 'Maladie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ...ajoutez ici toutes les autres données de la table `absences`...
        ]);
    }
}
