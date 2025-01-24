<?php

namespace App\Imports;

use App\Models\Convocation;
use Maatwebsite\Excel\Concerns\ToModel;

class ConvocationsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Convocation([
            //
        ]);
    }
}
