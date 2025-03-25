<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tuteur;
use App\Models\School;
use App\Models\Teacher;

class AuthController extends Controller
{
    public function loginTraitement(Request $request)
{
    // Validation des champs
    $request->validate([
        'username' => 'required|email',
        'password' => 'required',
    ]);

    $remember = $request->has('remember');

    // Vérification dans la table Tuteurs
    $tuteur = Tuteur::where('email', $request->username)->first();
    if ($tuteur && password_verify($request->password, $tuteur->password)) {
        // Authentification réussie pour un Tuteur
        Auth::loginUsingId($tuteur->id, $remember);
        return redirect('parent')->with('success', 'Bienvenue, parent!');
    }

    // Vérification dans la table Schools
    $school = School::where('email', $request->username)->first();
    if ($school && password_verify($request->password, $school->password)) {
        // Authentification réussie pour une École
        Auth::loginUsingId($school->id, $remember);
        return redirect('school')->with('success', 'Bienvenue, école!');
    }

     // Vérification dans la table teacher
     $teacher = Teacher::where('email', $request->username)->first();
     if ($teacher && password_verify($request->password, $teacher->password)) {
         // Authentification réussie pour une École
         Auth::loginUsingId($teacher->id, $remember);
         return redirect('teacher')->with('success', 'Bienvenue, école!');
     }

    // Si aucune correspondance
    return back()->withErrors(['error' => 'Identifiants incorrects.'])->withInput();
}

    public function dashboard()
{
    $tuteur = Auth::user(); // Utilisateur actuellement connecté
    return view('dashboard', compact('tuteur'));
}

}
