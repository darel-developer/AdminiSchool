<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

class SchoolController extends Controller
{
    public function ajouter_school_traitement(Request $request) {
        $request->validate([
            
            'schoolName' => 'required',
            'username' => 'required|email',
            'password' => 'required|confirmed', // Utilise le champ `password_confirmation`
        ]);
    
        $school = new School();
        $school->name = $request->schoolName;
        $school->email = $request->username;
        $school->password = bcrypt($request->password); // Chiffrez le mot de passe
        $school->type = 'school'; // Ajoutez un type par défaut si nécessaire
        $school->save();
    
        return redirect('login')->with('success', 'Parent ajouté avec succès');
    }
    
} 