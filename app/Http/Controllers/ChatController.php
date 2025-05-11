<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Teacher;
use App\Models\Tuteur;
use App\Models\Student;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'message' => 'required|string|max:1000',
            'child_id' => 'required|exists:students,id'
        ]);

        $user = Auth::user();
        $message = new Message();
        $message->message = $validated['message'];
        $message->teacher_id = $validated['teacher_id'];
        $message->tuteur_id = $user->id;
        $message->student_id = $validated['child_id']; // Link message to the child
        $message->save();

        return response()->json(['success' => true]);
    }

    public function fetchMessages($teacherId, Request $request)
    {
        $childId = $request->query('child_id');
        $student = Student::find($childId);

        if (!$student) {
            return response()->json(['error' => 'Enfant non trouvé.'], 404);
        }

        $user = Auth::user();
        if ($user instanceof Tuteur) {
            $messages = Message::where('tuteur_id', $user->id)
                ->where('teacher_id', $teacherId)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            return response()->json(['error' => 'Utilisateur non autorisé.'], 403);
        }

        return response()->json(['messages' => $messages]);
    }

    public function getTeachers(Request $request)
    {
        $childId = $request->query('child_id');
        $student = Student::find($childId);

        if (!$student) {
            return response()->json(['error' => 'Enfant non trouvé.'], 404);
        }

        $classe = Classe::where('name', $student->class)->first();
        if (!$classe) {
            return response()->json(['error' => 'Classe non trouvée.'], 404);
        }

        $teachers = Teacher::where('class_id', $classe->id)->get();
        return response()->json(['teachers' => $teachers]);
    }

    public function getParents(Request $request)
    {
        $teacher = Auth::guard('teacher')->user();

        // Vérifiez si l'enseignant est authentifié
        if (!$teacher) {
            Log::error('Enseignant non authentifié.');
            return response()->json(['error' => 'Enseignant non authentifié.'], 403);
        }

        Log::info('Enseignant connecté.', ['teacher_id' => $teacher->id, 'class_id' => $teacher->class_id]);

        // Étape 1 : Récupérer la classe de l'enseignant
        $classe = $teacher->classe;
        if (!$classe) {
            Log::error('Classe non trouvée pour l\'enseignant.', ['teacher_id' => $teacher->id]);
            return response()->json(['error' => 'Classe non trouvée pour cet enseignant.'], 404);
        }

        Log::info('Classe trouvée pour l\'enseignant.', ['class_name' => $classe->name]);

        // Étape 2 : Trouver les étudiants dans cette classe
        $students = Student::where('class', $classe->name)->get();
        if ($students->isEmpty()) {
            Log::info('Aucun étudiant trouvé pour cette classe.', ['class_name' => $classe->name]);
            return response()->json(['error' => 'Aucun étudiant trouvé pour cette classe.'], 404);
        }

        Log::info('Étudiants trouvés pour la classe.', ['students' => $students->toArray()]);

        // Étape 3 : Trouver les tuteurs associés à ces étudiants
        $parents = Tuteur::whereIn('child_name', $students->pluck('name'))->get();
        if ($parents->isEmpty()) {
            Log::info('Aucun parent trouvé pour les étudiants de cette classe.', ['class_name' => $classe->name]);
            return response()->json(['error' => 'Aucun parent trouvé pour cette classe.'], 404);
        }

        Log::info('Liste des parents récupérée.', ['parents' => $parents->toArray()]);

        // Retourner les parents trouvés
        return response()->json(['parents' => $parents]);
    }

    public function parentChat()
    {
        $tuteur = Auth::guard('tuteur')->user();
        $students = $tuteur ? $tuteur->students : collect(); // Fetch associated students or return an empty collection
        return view('parentchat', compact('students'));
    }

    public function teacherChat()
    {
        $user = Auth::guard('teacher')->user();

        if (!$user) {
            Log::error('Utilisateur non authentifié pour accéder à teacherChat.');
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        Log::info('Utilisateur authentifié pour teacherChat.', ['user_id' => $user->id]);
        return view('teacherchat');
    }
}