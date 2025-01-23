<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuteur;

class TuteurController extends Controller
{
    public function ajouter_parent_traitement(Request $request)
    {
        // Validation des données envoyées
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'secondName' => 'required|string|max:255',
            'username' => 'required|email|unique:tuteurs,email',
            'password' => 'required|min:8|confirmed', // Vérifie la confirmation
            'childName' => 'required|string|max:255', // "schoolName" n'est pas présent ici
            'schoolName' => 'nullable|string|max:255', 
        ]);

        // Création du tuteur
        try {
            $tuteur = new Tuteur();
            $tuteur->nom = $validatedData['firstName'];
            $tuteur->prenom = $validatedData['secondName'];
            $tuteur->email = $validatedData['username'];
            $tuteur->password = bcrypt($validatedData['password']);
            $tuteur->type = 'parent';
            $tuteur->childName = $validatedData['childName'];
            $tuteur->schoolName = $validatedData['schoolName'];
            $tuteur->save();
        
            return redirect('login')->with('success', 'Parent ajouté avec succès !');
        } catch (\Exception $e) {
            // Affichez les détails de l'exception pour mieux comprendre l'erreur
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
        
    }
}
