<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Tuteur;
use App\Models\School;
use App\Models\Teacher;

class AuthController extends Controller
{
    public function loginTraitement(Request $request)
    {
        Log::info('Début du processus d\'authentification.', ['username' => $request->username]);

        $request->validate([
            'username' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        // Vérification dans la table Tuteurs
        Log::info('Vérification dans la table Tuteurs.');
        $tuteur = Tuteur::where('email', $request->username)->first();
        if ($tuteur) {
            Log::info('Tuteur trouvé.', ['tuteur_id' => $tuteur->id]);
            if (password_verify($request->password, $tuteur->password)) {
                Log::info('Mot de passe valide pour le Tuteur.');
                Auth::guard('tuteur')->loginUsingId($tuteur->id, $remember); // Use the 'tuteur' guard explicitly
                Log::info('Redirection vers la page parent.', ['route' => 'parent']);
                return redirect()->route('parent')->with('success', 'Bienvenue, parent!'); // Use route helper for consistency
            } else {
                Log::warning('Mot de passe invalide pour le Tuteur.', ['tuteur_id' => $tuteur->id]);
            }
        } else {
            Log::warning('Aucun Tuteur trouvé avec cet email.');
        }

        // Vérification dans la table Schools
        Log::info('Vérification dans la table Schools.');
        $school = School::where('email', $request->username)->first();
        if ($school) {
            Log::info('École trouvée.', ['school_id' => $school->id]);
            if (password_verify($request->password, $school->password)) {
                Log::info('Mot de passe valide pour l\'École.');
                Auth::guard('school')->loginUsingId($school->id, $remember);
                return redirect('dashboard')->with('success', 'Bienvenue, école!');
            } else {
                Log::warning('Mot de passe invalide pour l\'École.', ['school_id' => $school->id]);
            }
        } else {
            Log::warning('Aucune École trouvée avec cet email.');
        }

        // Vérification dans la table Teachers
        Log::info('Vérification dans la table Teachers.');
        $teacher = Teacher::where('email', $request->username)->first();
        if ($teacher) {
            Log::info('Professeur trouvé.', ['teacher_id' => $teacher->id]);
            if (password_verify($request->password, $teacher->password)) {
                Log::info('Mot de passe valide pour le Professeur.');
                Auth::guard('teacher')->loginUsingId($teacher->id, $remember);
                return redirect('teacher')->with('success', 'Bienvenue, prof!');
            } else {
                Log::warning('Mot de passe invalide pour le Professeur.', ['teacher_id' => $teacher->id]);
            }
        } else {
            Log::warning('Aucun Professeur trouvé avec cet email.');
        }

        // Si aucune correspondance
        Log::error('Échec de l\'authentification. Identifiants incorrects.', ['username' => $request->username]);
        return back()->withErrors(['error' => 'Identifiants incorrects.'])->withInput();
    }

    public function dashboard()
    {
        $tuteur = Auth::user(); // Utilisateur actuellement connecté
        return view('dashboard', compact('tuteur'));
    }
}
