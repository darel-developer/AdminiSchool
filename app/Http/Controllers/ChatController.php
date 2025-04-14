<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Teacher;
use App\Models\Tuteur;
use App\Models\Student;
use App\Models\Classe;
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

    public function getTeachers()
{
    $user = auth()->guard('tuteur')->user();
    if (!$user) {
        return response()->json(['error' => 'Utilisateur non connecté'], 401);
    }

    $teachers = Teacher::whereHas('classes', function ($query) use ($user) {
        $query->where('name', $user->students->first()->class);
    })->get();

    return response()->json(['teachers' => $teachers]);
}

public function getParents()
{
    $teacher = auth()->guard('teacher')->user();
    if (!$teacher) {
        return response()->json(['error' => 'Utilisateur non connecté'], 401);
    }

    $parents = Tuteur::whereHas('students', function ($query) use ($teacher) {
        $query->where('class', $teacher->class->name);
    })->get();

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