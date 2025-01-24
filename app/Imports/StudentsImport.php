<?php
namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Vérifiez que toutes les colonnes requises sont présentes
        if (!isset($row['name']) || !isset($row['class']) || !isset($row['enrollment_date']) || !isset($row['absences']) || !isset($row['convocations']) || !isset($row['warnings'])) {
            return null;
        }

        // Recherchez l'étudiant par nom
        $student = Student::where('name', $row['name'])->first();

        if ($student) {
            // Si l'étudiant existe, mettez à jour ses informations
            $student->update([
                'class' => $row['class'],
                'enrollment_date' => $row['enrollment_date'],
                'absences' => $row['absences'],
                'convocations' => $row['convocations'],
                'warnings' => $row['warnings'],
            ]);
            return $student;
        } else {
            // Si l'étudiant n'existe pas, insérez un nouvel enregistrement
            return new Student([
                'name' => $row['name'],
                'class' => $row['class'],
                'enrollment_date' => $row['enrollment_date'],
                'absences' => $row['absences'],
                'convocations' => $row['convocations'],
                'warnings' => $row['warnings'],
            ]);
        }
    }
}