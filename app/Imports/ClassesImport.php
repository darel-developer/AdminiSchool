<?php
namespace App\Imports;

use App\Models\Classe;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClassesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Classe([
            'name' => $row['name'],
        ]);
    }
}