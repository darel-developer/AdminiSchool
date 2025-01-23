<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuteur;
use App\Models\School;
use App\Models\Message;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $user = auth()->guard('tuteur')->user(); // Récupérer le tuteur connecté
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $schoolName = $user->schoolName; // Récupérer le nom de l'école du tuteur
        $school = School::where('name', $schoolName)->first(); // Vérifier si l'école existe

        if (!$school) {
            return response()->json(['error' => "L'école associée n'existe pas"], 404);
        }

        // Enregistrer le message dans la base de données
        $message = new Message();
        $message->content = $request->message;
        $message->tuteur_id = $user->id;
        $message->school_id = $school->id;
        $message->save();

        return response()->json(['success' => 'Message envoyé avec succès']);
    }

    public function fetchMessages()
    {
        $user = auth()->guard('tuteur')->user();
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $schoolName = $user->schoolName;
        $school = School::where('name', $schoolName)->first();

        if (!$school) {
            return response()->json(['error' => "L'école associée n'existe pas"], 404);
        }

        $messages = Message::where('school_id', $school->id)
            ->orWhere('tuteur_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function sendMessageFromSchool(Request $request)
{
    $school = auth()->guard('school')->user(); // École connectée
    if (!$school) {
        return response()->json(['error' => "École non connectée"], 401);
    }

    $message = new Message();
    $message->content = $request->message;
    $message->school_id = $school->id;
    $message->tuteur_id = $request->tuteur_id; // ID du tuteur
    $message->save();

    return response()->json(['success' => 'Message envoyé avec succès']);
}

public function fetchMessagesForSchool($tuteurId)
{
    $school = auth()->guard('school')->user();
    if (!$school) {
        return response()->json(['error' => "École non connectée"], 401);
    }

    $messages = Message::where('school_id', $school->id)
        ->where('tuteur_id', $tuteurId)
        ->orderBy('created_at', 'asc')
        ->get();

    return response()->json($messages);
}

}
