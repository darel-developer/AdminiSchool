<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $user = auth()->guard('tuteur')->user(); // Récupérer le tuteur connecté
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        // Enregistrer le message dans la base de données
        $message = new Message();
        $message->content = $request->message;
        $message->tuteur_id = $user->id;
        $message->save();

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function fetchMessages()
    {
        $messages = Message::all();
        return response()->json($messages);
    }
}