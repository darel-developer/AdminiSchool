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

        $classIds = $request->input('classes');
        $students = Student::whereIn('class_id', $classIds)->get();

        // Associer chaque PDF à l'élève par nom de fichier (nom + classe)
        $uploadedFiles = $request->file('bulletins');
        $found = 0;
        foreach ($uploadedFiles as $file) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // On suppose que le nom du fichier est "nom" ou "nom_classe" (ex: Jean_Dupont_6A.pdf)
            $student = $students->first(function($stu) use ($filename) {
                $expected1 = str_replace(' ', '_', strtolower($stu->name));
                $expected2 = $expected1 . '_' . (isset($stu->class->name) ? str_replace(' ', '_', strtolower($stu->class->name)) : '');
                $filenameLower = strtolower($filename);
                return $filenameLower === $expected1 || $filenameLower === $expected2;
            });
            if ($student) {
                // Stocke le PDF dans storage/app/public/bulletins/{student_id}.pdf
                $path = $file->storeAs('public/bulletins', $student->id . '.pdf');
                // Notifie le parent
                $parent = Tuteur::find($student->parent_id);
                if ($parent) {
                    Notification::create([
                        'tuteur_id' => $parent->id,
                        'message' => 'Le bulletin de notes de votre enfant ' . $student->name . ' est disponible.',
                    ]);
                }
                $found++;
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
