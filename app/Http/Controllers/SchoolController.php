<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SchoolController extends Controller
{
    // Affiche le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('school.register');
    }

    // Traite l'inscription
    public function register(Request $request)
    {
        // Validation des données
        $request->validate([
            'schoolName' => 'required|string|max:255|unique:schools,schoolName',
            'email' => 'required|email|max:255|unique:schools,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Création de l'école
        School::create([
            'schoolName' => $request->schoolName,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hachage du mot de passe
        ]);

        return redirect('school')->with('success', 'École inscrite avec succès !');
    }
}
