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
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;


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
    Log::info('Début de la méthode getChildData.', ['section' => $section]);

    if ($tuteur) {
        Log::info('Utilisateur connecté : ', ['tuteur' => $tuteur->id]);

        if ($tuteur->child_name) {
            $student = Student::where('name', $tuteur->child_name)->first();
            Log::info('Étudiant trouvé : ', ['student' => $student]);

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
                    case 'planning':
                        $planning = Planning::where('class', $student->class)->get();
                        $data = [
                            'planning' => $planning,
                        ];
                        break;
                    default:
                        Log::warning('Section inconnue demandée.', ['section' => $section]);
                        return response()->json(['success' => false, 'error' => 'Section inconnue.']);
                }

                Log::info('Données récupérées avec succès.', ['data' => $data]);
                return response()->json(['success' => true, 'data' => $data]);
            } else {
                Log::error('Aucun étudiant trouvé pour le tuteur.', ['tuteur_id' => $tuteur->id]);
                return response()->json(['success' => false, 'error' => 'Aucun étudiant trouvé.']);
            }
        } else {
            Log::error('Aucun enfant associé au tuteur.', ['tuteur_id' => $tuteur->id]);
            return response()->json(['success' => false, 'error' => 'Aucun enfant associé.']);
        }
    }

    Log::error('Tuteur non authentifié.');
    return response()->json(['success' => false, 'error' => 'Tuteur non authentifié.']);
}

    public function details()
    {
        $students = Student::all();
        return view('students.details', ['students' => $students]);
    }

    public function downloadPlanning()
{
    $tuteur = auth()->guard('tuteur')->user();

    if (!$tuteur || !$tuteur->child_name) {
        return redirect()->back()->with('error', 'Aucun enfant associé à ce tuteur.');
    }

    $student = Student::where('name', $tuteur->child_name)->first();

    if (!$student) {
        return redirect()->back()->with('error', 'Aucun étudiant trouvé.');
    }

    $planning = Planning::where('class', $student->class)->get();

    $pdf = Pdf::loadView('pdf.planning', ['planning' => $planning, 'student' => $student]);

    return $pdf->download('planning_' . $student->class . '.pdf');
}
}
