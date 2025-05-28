<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Tuteur;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller; // Ajout pour accès à middleware
use Illuminate\Support\Facades\Log;

class TeacherChatController extends Controller
{
    public function __construct()
    {
        parent::__construct(); // Optionnel, selon Laravel, mais safe
        $this->middleware('auth:teacher');
    }

    // Récupérer tous les parents avec leurs enfants
    public function getAllParents()
    {
        // Correction : assure-toi que la relation 'students' existe bien pour chaque tuteur
        $parents = Tuteur::with('students')->get();

        // Si tu as des tuteurs mais pas d'enfants liés, la liste children sera vide
        // Pour le debug, log le résultat
        if ($parents->isEmpty()) {
            Log::info('Aucun tuteur trouvé en base.');
        } else {
            Log::info('Tuteurs trouvés:', $parents->toArray());
        }

        $result = $parents->map(function ($parent) {
            return [
                'id' => $parent->id,
                'nom' => $parent->nom,
                'prenom' => $parent->prenom,
                'email' => $parent->email,
                'children' => $parent->students ? $parent->students->map(function ($student) {
                    return [
                        'id' => $student->id,
                        'name' => $student->name
                    ];
                })->values()->toArray() : []
            ];
        });

        // Correction : si tu veux voir tous les parents même sans enfants, ne filtre pas sur children
        if ($result->isEmpty()) {
            Log::info('Aucun parent structuré trouvé.');
        } else {
            Log::info('Parents structurés:', $result->toArray());
        }

        return response()->json(['parents' => $result]);
    }

    // Récupérer les messages entre l'enseignant connecté et un parent
    public function getMessages($parentId)
    {
        $teacher = Auth::guard('teacher')->user();
        if (!$teacher) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $messages = Message::with(['teacher:id,first_name,last_name', 'tuteur:id,nom,prenom'])
            ->where('teacher_id', $teacher->id)
            ->where('tuteur_id', $parentId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'attachment' => $message->attachment ? Storage::url($message->attachment) : null,
                    'sender' => $message->teacher_id
                        ? [
                            'id' => $message->teacher->id,
                            'name' => $message->teacher->first_name . ' ' . $message->teacher->last_name,
                            'type' => 'teacher'
                        ]
                        : [
                            'id' => $message->tuteur->id,
                            'name' => $message->tuteur->nom . ' ' . $message->tuteur->prenom,
                            'type' => 'parent'
                        ],
                    'created_at' => $message->created_at->format('Y-m-d H:i:s')
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    // Envoyer un message à un parent
    public function sendMessage(Request $request)
    {
        $teacher = Auth::guard('teacher')->user();
        if (!$teacher) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $validated = $request->validate([
            'parent_id' => 'required|exists:tuteurs,id',
            'message' => 'required_without:attachment|string|nullable',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
        ]);

        $messageData = [
            'teacher_id' => $teacher->id,
            'tuteur_id' => $validated['parent_id'],
            'message' => $validated['message'] ?? null
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('attachments/messages', 'public');
            $messageData['attachment'] = $path;
        }

        $message = Message::create($messageData);

        return response()->json([
            'success' => true,
            'message' => 'Message envoyé avec succès',
            'data' => [
                'id' => $message->id,
                'message' => $message->message,
                'attachment' => $message->attachment ? Storage::url($message->attachment) : null,
                'created_at' => $message->created_at->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
