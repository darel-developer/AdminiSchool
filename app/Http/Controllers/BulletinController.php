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

        // Récupérer les classes sélectionnées
        $classIds = $request->input('classes');
        $classNames = Classe::whereIn('id', $classIds)->pluck('name')->toArray();

        Log::info('Classes sélectionnées pour upload bulletin', ['classIds' => $classIds, 'classNames' => $classNames]);

        // Étudiants concernés
        $students = Student::whereIn('class', $classNames)->get();

        Log::info('Étudiants trouvés pour ces classes', ['students' => $students->pluck('id', 'name')->toArray()]);

        // Liste des parents déjà notifiés
        $parentsNotified = [];

        // S'assurer que le dossier existe
        $directoryPath = storage_path('app/public/bulletins');
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }

        // Traitement des fichiers uploadés
        $uploadedFiles = $request->file('bulletins');
        $found = 0;

        foreach ($uploadedFiles as $file) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            Log::info('Traitement du fichier bulletin', ['filename' => $filename]);

            // Tentative de correspondance avec un élève
            $student = $students->first(function ($stu) use ($filename) {
                $expected1 = str_replace(' ', '_', strtolower($stu->name));
                $expected2 = $expected1 . '' . str_replace(' ', '', strtolower($stu->class));
                $expected3 = strtolower($stu->name); // nom brut

                $filenameLower = strtolower($filename);

                return $filenameLower === $expected1 || $filenameLower === $expected2 || $filenameLower === $expected3;
            });

            if ($student) {
                Log::info('Match trouvé pour le fichier bulletin', [
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                ]);

                $pdfName = $student->id . '.pdf';
                $file->storeAs('public/bulletins', $pdfName);

                Log::info('Bulletin stocké', [
                    'path' => storage_path('app/public/bulletins/' . $pdfName)
                ]);

                // Notification du tuteur
                if ($student->tuteur_id && !in_array($student->tuteur_id, $parentsNotified)) {
                    Notification::create([
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

        // Notifier les tuteurs restants même sans fichier
        foreach ($students as $student) {
            if ($student->tuteur_id && !in_array($student->tuteur_id, $parentsNotified)) {
                Notification::create([
                    'tuteur_id' => $student->tuteur_id,
                    'message' => 'Le bulletin de notes de votre enfant ' . $student->name . ' est déjà disponible.',
                ]);
                Log::info('Notification envoyée au tuteur (sans PDF)', ['tuteur_id' => $student->tuteur_id]);
                $parentsNotified[] = $student->tuteur_id;
            }
        }

        Log::info('Upload bulletins terminé', ['found' => $found, 'total_students' => count($students)]);

        return back()->with('success', "$found bulletins associés et notifications envoyées.");
    }

    // Interface parent : liste des bulletins disponibles
    public function parentBulletins()
    {
        $parent = auth('tuteur')->user();
        $students = Student::where('parent_id', $parent->id)->get();

        return view('parent.bulletins', compact('students'));
    }

    // Téléchargement d’un bulletin
    public function download($studentId)
    {
        $parent = auth('tuteur')->user();

        $student = Student::where('id', $studentId)
            ->where('parent_id', $parent->id)
            ->firstOrFail();

        $relativePath = 'public/bulletins/' . $student->id . '.pdf';

        if (!Storage::exists($relativePath)) {
            abort(404, 'Bulletin non disponible');
        }

        return Storage::download($relativePath, 'bulletin_' . $student->id . '.pdf');
    }
}