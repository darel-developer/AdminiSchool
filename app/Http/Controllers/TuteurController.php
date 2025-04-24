<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuteur;
use App\Models\Student;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;

class TuteurController extends Controller
{
    public function ajouter_parent_traitement(Request $request)
    {
        
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:tuteurs,email',
            'phone_number' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
        ]);

        // Création du tuteur
        $tuteur = new Tuteur();
        $tuteur->nom = $validatedData['nom'];
        $tuteur->prenom = $validatedData['prenom'];
        $tuteur->email = $validatedData['email'];
        $tuteur->phone_number = '+237' . ltrim($validatedData['phone_number'], '0');
        $tuteur->password = bcrypt($validatedData['password']);
        $tuteur->save();

        return redirect()->route('login')->with('success', 'Parent ajouté avec succès.');
    }

    public function addChild(Request $request)
    {
       
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|string|max:255',
            'tuteur_id' => 'required|integer|exists:tuteurs,id',
        ]);

        // créer un nouvent élève
        $student = Student::create([
            'name' => $validatedData['name'],
            'class' => $validatedData['class_id'],
            'enrollment_date' => null,
            'absences' => 0,
            'convocations' => 0,
            'warnings' => 0,
        ]);

        // mettre à jour le tuteur avec le nom de l'élève
        $tuteur = Tuteur::find($validatedData['tuteur_id']);
        $tuteur->child_name = $validatedData['name'];
        $tuteur->students()->attach($student->id);
        $tuteur->save();

        return redirect()->back()->with('success', 'Enfant ajouté avec succès.');
    }

    public function showAddChildForm()
    {
        $classes = Classe::all();
        return view('parentchild', compact('classes'));
    }
    
    public function dashboard()
    {
        $tuteur = auth()->guard('tuteur')->user();
        $students = $tuteur->students;
        return view('parent', compact('students'));
    }

    public function index()
    {
        $tuteurs = Tuteur::all();
        return view('userschool', compact('tuteurs'));
    }

    public function edit($id)
    {
        $tuteur = Tuteur::findOrFail($id);
        return view('profile', compact('tuteur'));
    }

    public function update(Request $request, $id)
    {
        $tuteur = Tuteur::findOrFail($id);
        $tuteur->fill($request->all());
        $tuteur->save();
        return redirect()->route('users')->with('success', 'Tuteur mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $tuteur = Tuteur::findOrFail($id);
        $tuteur->delete();
        return redirect()->route('users')->with('success', 'Tuteur supprimé avec succès.');
    }

    public function setting()
    {
        $tuteur = Auth::guard('tuteur')->user();
        $students = $tuteur->students;
        return view('profileschool', compact('tuteur', 'students'));
    }

   /* public function updateProfile(Request $request)
    {
        $tuteur = Auth::guard('tuteur')->user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:tuteurs,email,' . $tuteur->id,
            'phone_number' => 'required|string|max:255',
        ]);

        $tuteur->update($request->all());

        return redirect()->route('tuteur.profile')->with('success', 'Profil mis à jour avec succès.');
    } */
}
