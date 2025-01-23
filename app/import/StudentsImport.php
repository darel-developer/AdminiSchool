<?php
// filepath: /c:/xampp/htdocs/Adminischool/app/Imports/StudentsImport.php


namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Excel;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Student([
            'name'            => $row['name'],
            'class'           => $row['class'],
            'enrollment_date' => \Carbon\Carbon::parse($row['enrollment_date']),
            'absences'        => $row['absences'],
            'convocations'    => $row['convocations'],
            'warnings'        => $row['warnings'],
        ]);
    }
}