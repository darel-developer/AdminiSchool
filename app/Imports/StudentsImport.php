<?php
namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Check if the student already exists
        $student = Student::where('name', $row['name'])->first();

        if ($student) {
            // Update existing student
            $student->update([
                'class' => $row['class'],
                'enrollment_date' => $this->transformDate($row['enrollment_date']),
                'absences' => $row['absences'],
                'convocations' => $row['convocations'],
                'warnings' => $row['warnings'],
            ]);
            return null; // Return null to indicate no new model should be created
        } else {
            // Insert new student
            return new Student([
                'name' => $row['name'],
                'class' => $row['class'],
                'enrollment_date' => $this->transformDate($row['enrollment_date']),
                'absences' => $row['absences'],
                'convocations' => $row['convocations'],
                'warnings' => $row['warnings'],
            ]);
        }
    }

    /**
     * Transform Excel date to a proper date format.
     *
     * @param mixed $value
     * @return string
     */
    private function transformDate($value)
    {
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }
        return $value;
    }
}