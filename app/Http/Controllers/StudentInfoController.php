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

    public function getChildData($section, $childId = null)
    {
        // Récupérer le tuteur connecté
        $tuteur = auth()->guard('tuteur')->user();

        // Si $childId est fourni, on récupère l'enfant par ID, sinon par nom (pour compatibilité)
        if ($childId) {
            $student = Student::where('id', $childId)->where('parent_id', $tuteur->id)->first();
        } elseif ($tuteur && $tuteur->childName) {
            $student = Student::where('name', $tuteur->childName)->first();
        } else {
            $student = null;
        }

        if ($student) {
            $data = [];
            switch ($section) {
                case 'information':
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
                case 'bulletin':
                    $path = storage_path('app/public/bulletins/' . $student->id . '.pdf');
                    if (file_exists($path)) {
                        $url = asset('storage/bulletins/' . $student->id . '.pdf');
                        $data = ['url' => $url];
                        return response()->json(['success' => true, 'data' => $data]);
                    } else {
                        return response()->json(['success' => false, 'error' => 'Bulletin non disponible.'], 404);
                    }
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
                'error' => 'Aucun étudiant trouvé avec ce nom ou cet ID.',
            ]);
        }
    }

    // Ajout pour servir le bulletin PDF d'un enfant
    public function getBulletin($childId)
    {
        // Vérifier que le tuteur connecté est bien le parent de l'enfant
        $tuteur = auth()->guard('tuteur')->user();
        $student = \App\Models\Student::where('id', $childId)->where('parent_id', $tuteur->id)->first();
        if (!$student) {
            return response()->json(['success' => false, 'error' => 'Enfant non trouvé.'], 404);
        }
        $path = storage_path('app/public/bulletins/' . $student->id . '.pdf');
        if (!file_exists($path)) {
            return response()->json(['success' => false, 'error' => 'Bulletin non disponible.'], 404);
        }
        // Générer une URL temporaire pour visualiser/télécharger le PDF
        $url = asset('storage/bulletins/' . $student->id . '.pdf');
        return response()->json(['success' => true, 'url' => $url]);
    }
}
