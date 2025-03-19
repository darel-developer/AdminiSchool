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
        if ($tuteur && $tuteur->childName) {
            // Chercher l'enfant dans la table 'students' avec le nom de l'enfant
            $student = Student::where('name', $tuteur->childName)->first();
    
            // Si l'enfant existe, retourner les données de l'enfant pour la section demandée
            if ($student) {
                $data = [];
                switch ($section) {
                    case 'information':
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
                    case 'note':
                        // Remplace par la logique de récupération des notes
                        $data = [
                            'notes' => 'Les notes seront affichées ici...',
                        ];
                        break;
                    case 'convocation':
                        // Remplace par la logique de récupération des convocations
                        $data = [
                            'convocations' => $student->convocations,
                        ];
                        break;
                    case 'planning':
                        // Logique de récupération du planning
                        $planning = Planning::where('class', $student->class)->get();
                        $data = [
                            'planning' => $planning,
                        ];
                        break;
                    case 'barbillard':
                        // Remplace par la logique de récupération du barbillard
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
                    'error' => 'Aucun étudiant trouvé avec ce nom.',
                ]);
            }
        }
    
        return response()->json([
            'success' => false,
            'error' => 'Tuteur non trouvé ou enfant non associé.',
        ]);
    }
}
