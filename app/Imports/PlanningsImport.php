<?php

namespace App\Imports;

use App\Models\Planning;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PlanningsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Vérifiez si la date est un nombre (format de date Excel)
        if (is_numeric($row['date'])) {
            $date = Date::excelToDateTimeObject($row['date']);
        } else {
            // Sinon, essayez de créer un objet DateTime à partir de la chaîne de caractères
            $date = \DateTime::createFromFormat('d/m/Y', $row['date']);
            if (!$date) {
                // Si la création de l'objet DateTime échoue, utilisez la date actuelle comme valeur par défaut
                $date = new \DateTime();
            }
        }

        return new Planning([
            'class' => $row['class'],
            'date' => $date,
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'code' => $row['code'],
            'teacher' => $row['teacher'],
            'room' => $row['room'],
        ]);
    }
}