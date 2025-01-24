<?php

namespace App\Imports;

use App\Models\Absence;
use Maatwebsite\Excel\Concerns\ToModel;

class AbsencesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Absence([
            'student_name' => $row['student_name'],
            'absence_date' => $row['absence_date'],
            'reason' => $row['reason'] ?? null,
        ]);
    }
}
