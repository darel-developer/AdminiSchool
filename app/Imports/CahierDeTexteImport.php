<?php

namespace App\Imports;

use App\Models\CahierDeTexte;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class CahierDeTexteImport implements ToModel, WithHeadingRow, WithValidation
{
    private $rowCount = 0;

    public function model(array $row)
    {
        // Vérification des champs requis
        if (empty($row['date'])) {
            return null;
        }

        $this->rowCount++;

        return new CahierDeTexte([
            'date' => $this->transformDate($row['date']),
            'matiere' => $row['matiere'] ?? '',
            'contenu' => $row['contenu'] ?? '',
            'professeur' => $row['professeur'] ?? '',
            'devoirs' => $row['devoirs'] ?? null,
            'class' => $row['class'] ,
        ]);
    }

    public function rules(): array
    {
        return [
            'date' => 'required',
            'matiere' => 'required',
            'professeur' => 'required',
            'class' => 'required'
        ];
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    protected function transformDate($value)
    {
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return Carbon::createFromFormat('d/m/Y', $value);
        }
    }
}
