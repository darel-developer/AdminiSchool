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
        $students = \App\Models\Student::whereIn('class', $classNames)->get();

        // Liste des parents à notifier (évite les doublons)
        $parentsNotified = [];

        // Associer chaque PDF à l'élève par nom de fichier (nom + classe)
        $uploadedFiles = $request->file('bulletins');
        $found = 0;
        foreach ($uploadedFiles as $file) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // On suppose que le nom du fichier est "nom" ou "nom_classe" (ex: Jean_Dupont_6A.pdf)
            $student = $students->first(function($stu) use ($filename) {
                $expected1 = str_replace(' ', '_', strtolower($stu->name));
                $expected2 = $expected1 . '_' . (str_replace(' ', '_', strtolower($stu->class)));
                $filenameLower = strtolower($filename);
                return $filenameLower === $expected1 || $filenameLower === $expected2;
            });
            if ($student) {
                // Stocke le PDF dans storage/app/public/bulletins/{student_id}.pdf
                $path = $file->storeAs('public/bulletins', $student->id . '.pdf');
                // Notifie le parent (tuteur)
                if ($student->tuteur_id && !in_array($student->tuteur_id, $parentsNotified)) {
                    \App\Models\Notification::create([
                        'tuteur_id' => $student->tuteur_id,
                        'message' => 'Le bulletin de notes de votre enfant ' . $student->name . ' est disponible.',
                    ]);
                    $parentsNotified[] = $student->tuteur_id;
                }
                $found++;
            }
        }

        // Notifier tous les parents de la classe même si le PDF n'a pas été trouvé pour leur enfant
        foreach ($students as $student) {
            if ($student->tuteur_id && !in_array($student->tuteur_id, $parentsNotified)) {
                \App\Models\Notification::create([
                    'tuteur_id' => $student->tuteur_id,
                    'message' => 'Le bulletin de notes de votre enfant ' . $student->name . ' est disponible.',
                ]);
                $parentsNotified[] = $student->tuteur_id;
            }
        }

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
