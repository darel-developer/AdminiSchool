<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuteur;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;

class StudentController extends Controller
{
    public function fetchStudentInfo(Request $request)
    {
        // Supposons que le tuteur est connecté
        $tuteur = \Illuminate\Support\Facades\Auth::user();

        // Vérification si le tuteur est authentifié
        if (!$tuteur) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tuteur non authentifié.'
            ]);
        }

        // Récupération de l'étudiant associé
        $student = $tuteur->student;

        if ($student) {
            return response()->json([
                'status' => 'success',
                'data' => $student
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Aucun étudiant trouvé pour ce tuteur.'
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'studentFile' => 'required|mimes:xlsx,xls,csv,txt',
        ]);

        Excel::import(new StudentsImport, $request->file('studentFile'));

        return redirect()->back()->with('success', 'Données des élèves importées avec succès!');
    }
}
