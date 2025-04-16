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
    Log::info('Début de l\'envoi du message.');

    $validated = $request->validate([
        'teacher_id' => 'required|exists:teachers,id',
        'message' => 'required|string|max:1000',
    ]);

    Log::info('Données validées.', ['validated' => $validated]);

    $user = Auth::user();
    Log::info('Utilisateur connecté.', ['user' => $user]);

    $message = new Message();
    $message->message = $validated['message'];

    if ($user instanceof Tuteur) {
        $message->teacher_id = $validated['teacher_id'];
        $message->tuteur_id = $user->id;
        Log::info('Message envoyé par un tuteur.', ['tuteur_id' => $user->id, 'teacher_id' => $validated['teacher_id']]);
    } elseif ($user instanceof Teacher) {
        $message->tuteur_id = $validated['tuteur_id'] ?? null;
        $message->teacher_id = $user->id;
        Log::info('Message envoyé par un enseignant.', ['teacher_id' => $user->id, 'tuteur_id' => $validated['tuteur_id'] ?? null]);
    } else {
        Log::error('Utilisateur non autorisé.');
        return response()->json(['error' => 'Utilisateur non autorisé.'], 403);
    }

    $message->save();
    Log::info('Message sauvegardé.', ['message_id' => $message->id]);

    return response()->json(['success' => true]);
}

    public function fetchMessages($id)
    {
        $user = Auth::user();

        if ($user instanceof Tuteur) {
            $messages = Message::where('tuteur_id', $user->id)
                ->where('teacher_id', $id)
                ->get();
        } else {
            $messages = Message::where('teacher_id', $user->id)
                ->where('tuteur_id', $id)
                ->get();
        }

        Log::info('Messages récupérés.', ['user_id' => $user->id, 'conversation_with' => $id]);

        return response()->json(['messages' => $messages]);
    }

    public function getTeachers(Request $request)
    {
        $tuteur = Auth::user();
    
        // Étape 1 : Récupérer le nom de l'enfant associé au tuteur
        $childName = $tuteur->child_name;
        Log::info('Étape 1 : Tuteur connecté', ['tuteur_id' => $tuteur->id, 'child_name' => $childName]);
    
        if (!$childName) {
            return response()->json(['error' => 'Aucun enfant associé à ce tuteur.'], 404);
        }
    
        // Étape 2 : Trouver l'étudiant correspondant dans la table `students`
        $student = Student::where('name', $childName)->first();
        Log::info('Étape 2 : Étudiant trouvé', ['student' => $student]);
    
        if (!$student) {
            return response()->json(['error' => 'Aucun étudiant trouvé pour cet enfant.'], 404);
        }
    
        // Étape 3 : Trouver l'identifiant de la classe correspondant au nom de la classe
        $classe = Classe::where('name', $student->class)->first();
        Log::info('Étape 3 : Classe trouvée', ['classe' => $classe]);
    
        if (!$classe) {
            return response()->json(['error' => 'Aucune classe trouvée pour cet étudiant.'], 404);
        }
    
        // Étape 4 : Trouver les enseignants associés à cette classe
        $teachers = Teacher::where('class_id', $classe->id)->get();
        Log::info('Étape 4 : Enseignants trouvés', ['teachers' => $teachers]);
    
        if ($teachers->isEmpty()) {
            return response()->json(['error' => 'Aucun enseignant trouvé pour cette classe.'], 404);
        }
    
        // Étape 5 : Retourner les enseignants trouvés
        Log::info('Étape 5 : Liste des enseignants retournée', ['teachers' => $teachers->toArray()]);
        return response()->json(['teachers' => $teachers->toArray()]);
    }
    public function getParents(Request $request)
    {
        $teacher = Auth::user();
        $parents = Tuteur::whereHas('students', function ($query) use ($teacher) {
            $query->where('class', $teacher->class);
        })->get();

        Log::info('Enseignant a récupéré la liste des parents.', ['teacher_id' => $teacher->id]);

        return response()->json(['parents' => $parents]);
    }

    public function parentChat()
    {
        return view('parentchat'); // Assurez-vous que le fichier parentchat.blade.php existe dans resources/views
    }

    public function teacherChat()
    {
        return view('teacherchat'); // Assurez-vous que le fichier teacherchat.blade.php existe dans resources/views
    }
}