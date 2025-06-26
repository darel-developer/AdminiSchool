<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Student;
use App\Models\Tuteur;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BulletinController extends Controller
{
    // Upload des bulletins PDF et notification des parents
    public function upload(Request $request)
    {
        $request->validate([
            'bulletins' => 'required',
            'bulletins.*' => 'file|mimes:pdf',
            'classes' => 'required|array|min:1',
        ]);

        // Récupère les noms des classes à partir des IDs
        $classIds = $request->input('classes');
        $classNames = \App\Models\Classe::whereIn('id', $classIds)->pluck('name')->toArray();
        Log::info('Classes sélectionnées pour upload bulletin', ['classIds' => $classIds, 'classNames' => $classNames]);
        $students = \App\Models\Student::whereIn('class', $classNames)->get();
        Log::info('Étudiants trouvés pour ces classes', ['students' => $students->pluck('id', 'name')->toArray()]);

        // Liste des parents à notifier (évite les doublons)
        $parentsNotified = [];

        // Associer chaque PDF à l'élève par nom de fichier (nom + classe)
        $uploadedFiles = $request->file('bulletins');
        $found = 0;
        foreach ($uploadedFiles as $file) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            Log::info('Traitement du fichier bulletin', ['filename' => $filename]);
            $student = $students->first(function($stu) use ($filename) {
                $expected1 = str_replace(' ', '_', strtolower($stu->name));
                $expected2 = $expected1 . '_' . (str_replace(' ', '_', strtolower($stu->class)));
                $expected3 = strtolower($stu->name); // nom avec espaces
                $filenameLower = strtolower($filename);
                return $filenameLower === $expected1 || $filenameLower === $expected2 || $filenameLower === $expected3;
            });
            if ($student) {
                Log::info('Match trouvé pour le fichier bulletin', ['student_id' => $student->id, 'student_name' => $student->name]);
                // Stocke le PDF dans storage/app/public/bulletins/{nom_élève}.pdf (avec espaces)
                $pdfName = $student->name . '.pdf';
                $path = $file->storeAs('public/bulletins', $pdfName);
                Log::info('Bulletin stocké', ['path' => $path]);
                // Notifie le parent (tuteur)
                if ($student->tuteur_id && !in_array($student->tuteur_id, $parentsNotified)) {
                    \App\Models\Notification::create([
                        'tuteur_id' => $student->tuteur_id,
                        'message' => 'Le bulletin de notes de votre enfant ' . $student->name . ' est disponible.',
                    ]);
                    Log::info('Notification envoyée au tuteur', ['tuteur_id' => $student->tuteur_id]);
                    $parentsNotified[] = $student->tuteur_id;
                }
                $found++;
            } else {
                Log::warning('Aucun étudiant trouvé pour le fichier bulletin', ['filename' => $filename]);
            }
        }

        // Notifier tous les parents de la classe même si le PDF n'a pas été trouvé pour leur enfant
        foreach ($students as $student) {
            if ($student->tuteur_id && !in_array($student->tuteur_id, $parentsNotified)) {
                \App\Models\Notification::create([
                    'tuteur_id' => $student->tuteur_id,
                    'message' => 'Le bulletin de notes de votre enfant ' . $student->name . ' est disponible.',
                ]);
                Log::info('Notification envoyée au tuteur (sans PDF)', ['tuteur_id' => $student->tuteur_id]);
                $parentsNotified[] = $student->tuteur_id;
            }
        }

        Log::info('Upload bulletins terminé', ['found' => $found, 'total_students' => count($students)]);
        return back()->with('success', "$found bulletins associés et notifications envoyées.");
    }

    // Interface parent : liste des bulletins disponibles pour ses enfants
    public function parentBulletins()
    {
        $parent = auth('tuteur')->user();
        $students = Student::where('parent_id', $parent->id)->get();
        return view('parent.bulletins', compact('students'));
    }

    // Téléchargement d'un bulletin par le parent
    public function download($studentId)
    {
        $parent = auth('tuteur')->user();
        $student = Student::where('id', $studentId)->where('parent_id', $parent->id)->firstOrFail();
        $path = storage_path('app/public/bulletins/' . $student->id . '.pdf');
        if (!file_exists($path)) {
            abort(404, 'Bulletin non disponible');
        }
        return response()->download($path, 'bulletin_' . $student->name . '.pdf');
    }
}
