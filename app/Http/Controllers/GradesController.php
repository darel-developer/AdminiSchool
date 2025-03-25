<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GradesImport;

class GradesController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'gradesFile' => 'required|file|mimes:xlsx,xls,csv,txt',
        ]);

        $file = $request->file('gradesFile');
        $filePath = $file->store('grades');

        // Importer les données du fichier
        Excel::import(new GradesImport, $filePath);

        return back()->with('status', 'Grades uploaded successfully!');
    }
}