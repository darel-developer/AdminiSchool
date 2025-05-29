<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Tuteur;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;

class TeacherChatController extends Controller
{
    // Supprime l'appel à parent::__construct() qui n'existe pas dans Controller
    public function __construct()
    {
        $this->middleware('auth:teacher');
    }

    // Récupérer uniquement les parents ayant des enfants dans la classe de l'enseignant connecté
    public function getAllParents()
    {
        $teacher = Auth::guard('teacher')->user();
        if (!$teacher) {
            return response()->json(['parents' => []]);
        }

        // Récupérer la classe de l'enseignant
        $classe = $teacher->classe;
        if (!$classe) {
            return response()->json(['parents' => []]);
        }

        // Récupérer les étudiants de cette classe
        $students = \App\Models\Student::where('class', $classe->name)->get();

        // Récupérer les tuteurs de ces étudiants
        $tuteurIds = $students->pluck('tuteur_id')->unique()->filter();
        $parents = Tuteur::with(['students' => function($query) use ($classe) {
            $query->where('class', $classe->name);
        }])->whereIn('id', $tuteurIds)->get();

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
