<?php
namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Use updateOrCreate to either update an existing student or create a new one
        return Student::updateOrCreate(
            ['name' => $row['name']], // Condition to check if the student exists
            [
                'class' => $row['class'],
                'enrollment_date' => $row['enrollment_date'],
                'absences' => $row['absences'],
                'convocations' => $row['convocations'],
                'warnings' => $row['warnings'],
            ]
        );
    }
}