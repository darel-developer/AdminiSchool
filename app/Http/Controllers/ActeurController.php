<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Models\acteur;
use App\Models\Schools;
use Hash;

class ActeurController extends Controller
{
    


    // Méthode pour traiter l'inscription
    public function register_utilisateur_traitement(Request $request)
    {
        $request->validate([
            'schoolName' => 'required_if:accountType,parent|string|max:255',
            'accountType' => 'required|string',
            'username' => 'required|string|email|max:255|unique:schools,username',
            'password' => 'required|string|confirmed|min:8',
        ]);
    
        // Récupérer toutes les écoles avant toute logique d'enregistrement
        $schools = Schools::all();
    
        if ($request->accountType === 'school') {
            $schoolsModel = new Schools();
            $schoolsModel->schoolName = $request->schoolName;
            $schoolsModel->username = $request->username;
            $schoolsModel->password = Hash::make($request->password);
            $schoolsModel->save();
        } else {
            // Sauvegarde dans la table `acteur`
            $acteur = new Acteur();
            $acteur->firstName = $request->firstName;
            $acteur->secondName = $request->secondName;
            $acteur->accountType = $request->accountType;
            $acteur->username = $request->username;
            $acteur->password = Hash::make($request->password);
    
            // Si c'est un parent, on remplit aussi childName et schoolName
            if ($request->accountType == 'parent') {
                $acteur->childName = $request->childName; // Nom de l'enfant
                $acteur->schoolName = $request->schoolName; // Nom de l'école
            }
    
            $acteur->save();
        }
    
        return view('register', compact('schools')); // Passe la variable $schools à la vue
    }

    public function showRegisterForm()
{
    $schools = School::all();  // Assuming you have a 'School' model
    return view('register', compact('schools'));
}

    
    
    
    



    // Méthode pour traiter la connexion
    public function login_connexion(Request $request)
    {
        $request->validate([
            'username' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
    
        // Recherche dans la table `schools`
        $school = \App\Models\Schools::where('username', $request->username)->first();
        if ($school && Hash::check($request->password, $school->password)) {
            Auth::login( $school);
            return redirect('/school')->with('success', 'Bienvenue sur l\'interface School.');
        }
    
        // Recherche dans la table `acteur`
        $acteur = Acteur::where('username', $request->username)->first();
        if ($acteur && Hash::check($request->password, $acteur->password)) {
            Auth::login($acteur);
            return $acteur->accountType === 'parent' 
                ? redirect('/parent')->with('success', 'Bienvenue sur l\'interface Parent.')
                : redirect()->route('dashboard')->with('success', 'Vous êtes connecté.');
        }
    
        return back()->withErrors(['login' => 'Identifiants incorrects.']);
    }
    



   
    

}