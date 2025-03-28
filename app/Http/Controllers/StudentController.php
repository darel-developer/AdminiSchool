<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Planning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tuteur;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use App\Imports\AbsencesImport;
use App\Imports\ConvocationsImport;

class StudentController extends Controller
{   
    public function upload(Request $request)
    {
        $request->validate([
            'studentFile' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('studentFile');

        Excel::import(new StudentsImport, $file);

        return back()->with('success', 'Les données des élèves ont été importées avec succès.');
    }

    public function uploadAbsences(Request $request)
    {
        $request->validate([
            'studentFile' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('studentFile');

        Excel::import(new AbsencesImport, $file);

        return back()->with('success', 'Les données des absences ont été importées avec succès.');
    }

    public function uploadConvocations(Request $request)
    {
        $request->validate([
            'studentFile' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('studentFile');

        Excel::import(new ConvocationsImport, $file);

        return back()->with('success', 'Les données des convocations ont été importées avec succès.');
    }

    public function getChildData($section)
{
    // Récupérer le tuteur connecté
    $tuteur = auth()->guard('tuteur')->user();
    
    // Vérifier si le tuteur a un enfant associé
    if ($tuteur && $tuteur->child_name) {
        // Chercher l'enfant dans la table 'students' avec le nom de l'enfant
        $student = Student::where('name', $tuteur->child_name)->first();

        if ($student) {
            $data = [];
            switch ($section) {
                case 'general':
                    $data = [
                        'name' => $student->name,
                        'class' => $student->class,
                        'enrollment_date' => $student->enrollment_date,
                        'absences' => $student->absences,
                        'convocations' => $student->convocations,
                        'warnings' => $student->warnings,
                    ];
                    break;
                case 'absence':
                    $data = [
                        'absences' => $student->absences,
                    ];
                    break;
                case 'notes':
                    // Logique de récupération des notes
                    $data = [
                        'notes' => $student->notes,
                    ];
                    break;
                case 'convocation':
                    $data = [
                        'convocations' => $student->convocations,
                    ];
                    break;
                case 'planning':
                    $planning = Planning::where('class', $student->class)->get();
                    $data = [
                        'planning' => $planning,
                    ];
                    break;
                case 'barbillard':
                    $data = [
                        'warnings' => $student->warnings,
                    ];
                    break;
                default:
                    return response()->json(['success' => false, 'error' => 'Section inconnue.']);
            }

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Aucun enfant trouvé.',
            ]);
        }
    }

    return response()->json([
        'success' => false,
        'error' => 'Tuteur non trouvé ou enfant non associé.',
    ]);
}
}
