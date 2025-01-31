<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClassesImport;

class ClasseController extends Controller
{
    public function ajouter_classe(Request $request)
    {
        $request->validate([
            'classFile' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('classFile');

        Excel::import(new ClassesImport, $file);

        return back()->with('success', 'Les données des classes ont été importées avec succès.');
    }
}