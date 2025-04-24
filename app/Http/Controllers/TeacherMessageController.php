<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Tuteur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\Models\Teacher;

use Illuminate\Routing\Controller;

class TeacherMessageController extends Controller
{
    public function getParents()
    {
        // Récupérer l'enseignant connecté
        $teacher = Auth::guard('teacher')->user();

        // Vérifier si l'enseignant est connecté
        if (!$teacher) {
            Log::error('Aucun enseignant connecté.');
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        Log::info('Enseignant connecté : ', ['id' => $teacher->id, 'name' => $teacher->name]);

        // Récupérer les parents dont les enfants sont dans la même classe que l'enseignant
        $parents = Tuteur::whereHas('students', function ($query) use ($teacher) {
            $query->where('class', $teacher->class->name); // Correspondance avec le nom de la classe
        })->get();

        if ($parents->isEmpty()) {
            Log::warning('Aucun parent trouvé pour la classe de l\'enseignant.', ['class' => $teacher->class->name]);
        } else {
            Log::info('Parents trouvés : ', $parents->toArray());
        }

        // Retourner les parents sous forme de JSON
        return response()->json(['parents' => $parents]);
    }

    public function getMessages($parentId)
    {
        $teacher = Auth::guard('teacher')->user();

        if (!$teacher) {
            Log::error('Aucun enseignant connecté.');
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        Log::info('Récupération des messages pour l\'enseignant : ', ['teacher_id' => $teacher->id, 'parent_id' => $parentId]);

        $messages = Message::where('teacher_id', $teacher->id)
            ->where('tuteur_id', $parentId)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($messages->isEmpty()) {
            Log::warning('Aucun message trouvé pour ce parent.', ['teacher_id' => $teacher->id, 'parent_id' => $parentId]);
        } else {
            Log::info('Messages trouvés : ', $messages->toArray());
        }

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required_without:file|string',
            'file' => 'nullable|file|max:2048',
            'parent_id' => 'required|exists:tuteurs,id',
        ]);

        $teacher = Auth::guard('teacher')->user();

        if (!$teacher) {
            Log::error('Aucun enseignant connecté.');
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        Log::info('Envoi d\'un message par l\'enseignant : ', ['teacher_id' => $teacher->id, 'parent_id' => $request->parent_id]);

        $message = new Message();
        $message->teacher_id = $teacher->id;
        $message->tuteur_id = $request->parent_id;
        $message->message = $request->message;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('messages');
            $message->file_path = $path;
            Log::info('Fichier attaché au message : ', ['file_path' => $path]);
        }

        $message->save();

        Log::info('Message envoyé avec succès : ', $message->toArray());

        return response()->json(['success' => true]);
    }
}
