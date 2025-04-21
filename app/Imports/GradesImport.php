<?php

namespace App\Imports;

use App\Models\Grades;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GradesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Vérifiez si la valeur de grade est un nombre valide
        if (isset($row['grade']) && is_numeric($row['grade'])) {
            return new Grades([
                'student_name' => $row['student_name'],
                'grade' => (float) $row['grade'], // Convertir en float si c'est un nombre
                'matiere' => $row['matiere'],
            ]);
        }

        // Si la valeur de grade n'est pas valide, retournez null pour ignorer cette ligne
        return null;
    }
}