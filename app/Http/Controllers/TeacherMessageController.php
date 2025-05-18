<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Tuteur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use App\Models\Teacher;
use App\Models\Classe;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

use Illuminate\Routing\Controller;

class TeacherMessageController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:teacher');
    }

    public function getParents()
    {
        try {
            $teacher = Auth::guard('teacher')->user();
            if (!$teacher) {
                Log::error('Aucun enseignant connecté.');
                return response()->json(['error' => 'Non autorisé'], 403);
            }

            // Correction ici : accès à la relation sans parenthèses
            $classe = $teacher->classe;
            if (!$classe) {
                Log::error('Classe non trouvée pour l\'enseignant ID: ' . $teacher->id);
                return response()->json(['error' => 'Classe non trouvée'], 404);
            }

            // Récupérer les étudiants de la classe
            $students = Student::where('class', $classe->name)->with('tuteur')->get();

            // Grouper les parents par tuteur_id
            $parents = $students
                ->groupBy('tuteur_id')
                ->map(function ($students, $tuteurId) {
                    $tuteur = $students->first()->tuteur;
                    if (!$tuteur) return null;

                    return [
                        'id' => $tuteur->id,
                        'nom' => $tuteur->nom,
                        'prenom' => $tuteur->prenom,
                        'email' => $tuteur->email,
                        'children' => $students->map(function ($student) {
                            return [
                                'id' => $student->id,
                                'name' => $student->name
                            ];
                        })->values()->toArray()
                    ];
                })
                ->filter()
                ->values();

            if ($parents->isEmpty()) {
                Log::info('Aucun parent trouvé pour la classe: ' . $classe->name);
                return response()->json(['error' => 'Aucun parent trouvé'], 404);
            }

            return response()->json([
                'parents' => $parents,
                'success' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des parents: ' . $e->getMessage());
            return response()->json([
                'error' => 'Une erreur est survenue lors de la récupération des parents',
                'success' => false
            ], 500);
        }
    }

    public function getMessages($parentId)
    {
        try {
            $teacher = Auth::guard('teacher')->user();

            if (!$teacher) {
                Log::error('Aucun enseignant connecté.');
                return response()->json(['error' => 'Non autorisé'], 403);
            }

            // Vérifier si le parent existe et est lié à un élève de la classe de l'enseignant
            $tuteur = Tuteur::whereHas('students', function($query) use ($teacher) {
                $query->where('class_id', $teacher->class_id);
            })->find($parentId);

            if (!$tuteur) {
                Log::error('Parent non autorisé pour cet enseignant');
                return response()->json(['error' => 'Parent non trouvé ou non autorisé'], 404);
            }

            $messages = Message::with(['teacher:id,first_name,last_name', 'tuteur:id,nom,prenom'])
                ->where(function($query) use ($teacher, $parentId) {
                    $query->where('teacher_id', $teacher->id)
                          ->where('tuteur_id', $parentId);
                })
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($message) {
                    return [
                        'id' => $message->id,
                        'message' => $message->message,
                        'attachment' => $message->attachment ? Storage::url($message->attachment) : null,
                        'sender' => $message->teacher_id ? [
                            'id' => $message->teacher->id,
                            'name' => $message->teacher->first_name . ' ' . $message->teacher->last_name,
                            'type' => 'teacher'
                        ] : [
                            'id' => $message->tuteur->id,
                            'name' => $message->tuteur->nom . ' ' . $message->tuteur->prenom,
                            'type' => 'parent'
                        ],
                        'created_at' => $message->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return response()->json(['messages' => $messages]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des messages: ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des messages'], 500);
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            Log::info('Début de sendMessage', [
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'message' => 'required_without:attachment|string|nullable',
                'parent_id' => 'required|exists:tuteurs,id',
                'student_id' => 'nullable|exists:students,id',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
            ]);

            Log::info('Données validées', [
                'validated_data' => $validated
            ]);

            $teacher = Auth::guard('teacher')->user();

            if (!$teacher) {
                Log::error('Aucun enseignant connecté.');
                return response()->json(['error' => 'Non autorisé'], 403);
            }

            Log::info('Enseignant trouvé', [
                'teacher_id' => $teacher->id,
                'teacher_name' => $teacher->first_name . ' ' . $teacher->last_name
            ]);

            // Vérification supplémentaire pour student_id
            if (isset($validated['student_id'])) {
                $student = Student::where('id', $validated['student_id'])
                    ->where('class_id', $teacher->class_id)
                    ->first();

                if (!$student) {
                    return response()->json(['error' => 'Élève non trouvé ou non autorisé'], 403);
                }
            }

            // Vérifier si le parent est autorisé
            $tuteur = Tuteur::whereHas('students', function($query) use ($teacher) {
                $query->where('class_id', $teacher->class_id);
            })->find($validated['parent_id']);

            if (!$tuteur) {
                Log::error('Parent non autorisé', [
                    'parent_id' => $validated['parent_id'],
                    'teacher_class_id' => $teacher->class_id
                ]);
                return response()->json(['error' => 'Parent non autorisé'], 403);
            }

            Log::info('Parent trouvé', [
                'tuteur_id' => $tuteur->id,
                'tuteur_name' => $tuteur->nom . ' ' . $tuteur->prenom
            ]);

            $messageData = [
                'teacher_id' => $teacher->id,
                'tuteur_id' => $validated['parent_id'],
                'student_id' => $validated['student_id'] ?? null,
                'message' => $validated['message'] ?? null
            ];

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $path = $file->store('attachments/messages', 'public');
                $messageData['attachment'] = $path;
                Log::info('Fichier joint traité', [
                    'original_name' => $file->getClientOriginalName(),
                    'stored_path' => $path
                ]);
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

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du message: ' . $e->getMessage());
            return response()->json([
                'error' => 'Une erreur est survenue lors de l\'envoi du message',
                'success' => false
            ], 500);
        }
    }
}
