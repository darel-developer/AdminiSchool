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
        try {
            $validated = $request->validate([
                'message' => 'required_without:attachment|string|nullable',
                'teacher_id' => 'required|exists:teachers,id',
                'student_id' => 'nullable|exists:students,id',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
            ]);

            $tuteur = Auth::guard('tuteur')->user();
            if (!$tuteur) {
                return response()->json(['error' => 'Non autorisé'], 403);
            }

            // Vérifier si l'enseignant est lié à un des enfants du tuteur
            $teacher = Teacher::whereIn('class_id', function($query) use ($tuteur) {
                $query->select('class_id')
                    ->from('students')
                    ->where('tuteur_id', $tuteur->id);
            })->find($validated['teacher_id']);

            if (!$teacher) {
                return response()->json(['error' => 'Enseignant non autorisé'], 403);
            }

            $messageData = [
                'teacher_id' => $validated['teacher_id'],
                'tuteur_id' => $tuteur->id,
                'student_id' => $validated['student_id'] ?? null,
                'message' => $validated['message'] ?? null
            ];

            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('attachments/messages', 'public');
                $messageData['attachment'] = $path;
            }

            $message = Message::create($messageData);

            return response()->json([
                'success' => true,
                'message' => 'Message envoyé avec succès',
                'data' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'attachment' => $message->attachment ? asset('storage/' . $message->attachment) : null,
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

    public function fetchMessages($teacherId)
    {
        try {
            $tuteur = Auth::guard('tuteur')->user();
            if (!$tuteur) {
                Log::error('Tuteur non authentifié');
                return response()->json(['error' => 'Non autorisé'], 403);
            }

            // Vérifier si l'enseignant existe et est lié à un des enfants du tuteur
            $teacher = Teacher::whereIn('class_id', function($query) use ($tuteur) {
                $query->select('class_id')
                    ->from('students')
                    ->where('tuteur_id', $tuteur->id);
            })->find($teacherId);

            if (!$teacher) {
                Log::error('Enseignant non trouvé ou non autorisé', [
                    'teacher_id' => $teacherId,
                    'tuteur_id' => $tuteur->id
                ]);
                return response()->json(['error' => 'Enseignant non trouvé ou non autorisé'], 404);
            }

            // Récupérer tous les messages entre le tuteur et l'enseignant
            $messages = Message::with(['teacher:id,first_name,last_name', 'tuteur:id,nom,prenom'])
                ->where(function($query) use ($tuteur, $teacherId) {
                    $query->where('tuteur_id', $tuteur->id)
                          ->where('teacher_id', $teacherId);
                })
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($message) {
                    return [
                        'id' => $message->id,
                        'message' => $message->message,
                        'attachment' => $message->attachment ? asset('storage/' . $message->attachment) : null,
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

            Log::info('Messages récupérés avec succès', [
                'count' => $messages->count(),
                'teacher_id' => $teacherId,
                'tuteur_id' => $tuteur->id
            ]);

            return response()->json(['messages' => $messages]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des messages: ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des messages'], 500);
        }
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

        // Récupérer les étudiants avec leurs classes
        $students = Student::where('tuteur_id', $tuteur->id)
            ->with('classe')
            ->get();

        // Récupérer les enseignants pour toutes les classes des étudiants
        $teachers = Teacher::whereIn('class_id', $students->pluck('class_id')->unique())
            ->get();

        // Ajouter des logs pour le débogage
        Log::info('Students data:', ['students' => $students->toArray()]);
        Log::info('Teachers data:', ['teachers' => $teachers->toArray()]);

        return view('parentchat', compact('students', 'teachers'));
    }

    public function teacherChat()
    {
        $user = Auth::guard('teacher')->user();

        if (!$user) {
            Log::error('Utilisateur non authentifié pour accéder à teacherChat.');
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer la classe de l'enseignant
        $classe = $user->classe;

        // Récupérer tous les élèves de la classe
        $students = Student::where('class', $classe->name)->with('tuteur')->get();

        // Récupérer tous les parents des élèves de la classe
        $parents = Tuteur::whereIn('id', $students->pluck('tuteur_id'))->get();

        Log::info('Utilisateur authentifié pour teacherChat.', ['user_id' => $user->id]);
        return view('teacherchat', compact('parents', 'students'));
    }
}
