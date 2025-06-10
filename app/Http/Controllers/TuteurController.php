<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuteur;
use App\Models\Student;
use App\Models\Classe;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 

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
        ]);

        $tuteur = auth()->guard('tuteur')->user();

        // Créer un nouvel élève et l'associer au tuteur
        $student = Student::create([
            'name' => $validatedData['name'],
            'class' => $validatedData['class_id'],
            'enrollment_date' => now(),
            'absences' => 0,
            'convocations' => 0,
            'warnings' => 0,
            'tuteur_id' => $tuteur->id, // Association avec le tuteur
        ]);

        return redirect()->back()->with('success', 'Enfant ajouté avec succès.');
    }

    public function showAddChildForm()
    {
        $classes = Classe::all(); // Fetch all classes from the database
        return view('parentchild', compact('classes'));
    }

    public function dashboard()
    {
        $tuteur = auth()->guard('tuteur')->user();
        $students = $tuteur->students; // Récupération des enfants liés au tuteur
        return view('parent', compact('students')); // Transmission de $students à la vue
    }

    public function index()
    {
        $tuteurs = Tuteur::all();
        $teachers = Teacher::with('classe')->get(); // Fetch teachers with their associated classes
        return view('userschool', compact('tuteurs', 'teachers'));
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
        $classes = Classe::all(); // Fetch all classes for the dropdown
        return view('profileschool', compact('tuteur', 'students', 'classes'));
    }

    public function editChild($id)
    {
        $tuteur = auth()->guard('tuteur')->user();
        $student = Student::where('id', $id)->where('tuteur_id', $tuteur->id)->firstOrFail();
        $classes = Classe::all();
        return view('editchild', compact('student', 'classes'));
    }

    public function updateChild(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|string|max:255',
        ]);

        $tuteur = auth()->guard('tuteur')->user();
        $student = Student::where('id', $id)->where('tuteur_id', $tuteur->id)->firstOrFail();

        $student->update([
            'name' => $validatedData['name'],
            'class' => $validatedData['class_id'],
        ]);

        return redirect()->route('parent')->with('success', 'Données de l\'enfant mises à jour avec succès.');
    }

    // Affiche la liste complète des tuteurs pour impression (HTML ou PDF)
    public function printTuteurs()
    {
        $tuteurs = \App\Models\Tuteur::all();
        // Pour une page HTML d'impression :
        return view('print.tuteurs', compact('tuteurs'));

        // Pour générer un PDF directement (décommente si tu veux du PDF) :
        // $pdf = Pdf::loadView('print.tuteurs', compact('tuteurs'));
        // return $pdf->download('liste_tuteurs.pdf');
    }

    // Affiche la liste complète des enseignants pour impression (HTML ou PDF)
    public function printEnseignants()
    {
        $teachers = \App\Models\Teacher::with('classe')->get();
        return view('print.enseignants', compact('teachers'));

        // Pour générer un PDF directement :
        // $pdf = Pdf::loadView('print.enseignants', compact('teachers'));
        // return $pdf->download('liste_enseignants.pdf');
    }
}