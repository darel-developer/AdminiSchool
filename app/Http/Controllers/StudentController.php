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
use Illuminate\Support\Facades\Storage;

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

    public function getChildData($section, $id)
    {
        $tuteur = auth()->guard('tuteur')->user();

        if ($tuteur) {
            $student = Student::where('id', $id)->where('tuteur_id', $tuteur->id)->first();

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
                        $data = ['planning' => Planning::where('class', $student->class)->get()];
                        break;

                    case 'notes':
                        $data = ['notes' => $student->notes];
                        break;

                    case 'absence':
                        $data = ['absences' => $student->absences];
                        break;

                    case 'convocation':
                        $data = ['convocations' => $student->convocations];
                        break;

                    case 'warnings':
                        $data = ['warnings' => $student->warnings];
                        break;

                    case 'edit': // New case for editing child data
                        $data = [
                            'name' => $student->name,
                            'class' => $student->class,
                            'id' => $student->id,
                        ];
                        break;

                    case 'bulletins':
                        $bulletinRelativePath = 'public/bulletins/' . $student->id . '.pdf';
                        
                        if (Storage::exists($bulletinRelativePath)) {
                            $url = asset('storage/bulletins/' . $student->id . '.pdf');
                            Log::info('[BULLETIN] Bulletin trouvé pour élève', [
                                'student_id' => $student->id,
                                'student_name' => $student->name,
                                'url' => $url,
                            ]);
                            $data = ['url' => $url];
                        } else {
                            Log::warning('[BULLETIN] Bulletin non trouvé pour élève', [
                                'student_id' => $student->id,
                                'student_name' => $student->name,
                                'expected_path' => $bulletinRelativePath
                            ]);
                            return response()->json([
                                'success' => false,
                                'error' => 'Bulletin non disponible.'
                            ]);
                        }
                        break;
                    default:
                        return response()->json(['success' => false, 'error' => 'La section demandée est inconnue ou invalide.']);
                }

                return response()->json(['success' => true, 'data' => $data]);
            } else {
                return response()->json(['success' => false, 'error' => 'Enfant non trouvé ou non associé à ce tuteur.']);
            }
        }

        return response()->json(['success' => false, 'error' => 'Tuteur non authentifié.']);
    }

    public function getChildDataById($id)
    {
        $tuteur = auth()->guard('tuteur')->user();

        if ($tuteur) {
            $student = Student::where('id', $id)->where('tuteur_id', $tuteur->id)->first();

            if ($student) {
                $data = [
                    'name' => $student->name,
                    'class' => $student->class,
                    'enrollment_date' => $student->enrollment_date,
                    'absences' => $student->absences,
                    'convocations' => $student->convocations,
                    'warnings' => $student->warnings,
                    'total_absences' => $student->absences, // Nombre total d'absences
                    'total_convocations' => $student->convocations, // Nombre total de convocations
                    'total_warnings' => $student->warnings, // Nombre total d'avertissements
                ];

                return response()->json(['success' => true, 'data' => $data]);
            } else {
                return response()->json(['success' => false, 'error' => 'Enfant non trouvé ou non associé à ce tuteur.']);
            }
        }

        return response()->json(['success' => false, 'error' => 'Tuteur non authentifié.']);
    }

    public function details()
    {
        $students = Student::all();
        return view('students.details', ['students' => $students]);
    }

    public function downloadPlanning($id)
    {
        $tuteur = auth()->guard('tuteur')->user();

        if (!$tuteur) {
            Log::error('Tuteur non authentifié.');
            return redirect()->back()->with('error', 'Tuteur non authentifié.');
        }

        $student = Student::where('id', $id)->where('tuteur_id', $tuteur->id)->first();

        if (!$student) {
            Log::error('Enfant non trouvé ou non associé.', ['tuteur_id' => $tuteur->id, 'student_id' => $id]);
            return redirect()->back()->with('error', 'Enfant non trouvé ou non associé à ce tuteur.');
        }

        // Récupérer le planning de la classe de l'enfant
        $planning = Planning::where('class', $student->class)->get();

        if ($planning->isEmpty()) {
            Log::info('Aucun planning disponible.', ['class' => $student->class]);
            return redirect()->back()->with('error', 'Aucun planning disponible pour cet étudiant.');
        }

        Log::info('Planning trouvé.', ['class' => $student->class, 'planning' => $planning]);

        // Générer le PDF
        $pdf = Pdf::loadView('pdf.planning', ['planning' => $planning, 'student' => $student]);

        return $pdf->download('planning_' . $student->class . '.pdf');
    }
}
