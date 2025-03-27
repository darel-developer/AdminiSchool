<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CahierDeTexte;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CahierDeTexteImport;
use Illuminate\Support\Facades\Storage;

class CahierDeTexteController extends Controller
{
    /**
     * Affiche le formulaire pour ajouter un cahier de texte.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('cahier_de_texte.create'); // Assurez-vous que cette vue existe
    }

    /**
     * Enregistre un cahier de texte dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valider le fichier uploadé
        $request->validate([
            'fichier' => 'required|mimes:xlsx,xls', // Seuls les fichiers Excel sont autorisés
        ]);

        // Traiter le fichier uploadé
        $file = $request->file('fichier');
        $fileName = time() . '_' . $file->getClientOriginalName(); // Nom unique pour le fichier
        $filePath = $file->storeAs('cahiers_de_texte', $fileName); // Stocker le fichier dans le dossier "cahiers_de_texte"

        // Importer les données du fichier Excel
        Excel::import(new CahierDeTexteImport, $filePath);

        // Enregistrer les informations du fichier dans la base de données
        CahierDeTexte::create([
            'nom_fichier' => $fileName,
            'chemin_fichier' => $filePath,
        ]);

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Cahier de texte ajouté avec succès.');
    }

    /**
     * Affiche la liste des cahiers de texte.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cahiers = CahierDeTexte::all(); // Récupérer tous les cahiers de texte
        return view('cahier_de_texte.index', compact('cahiers')); // Passer les cahiers à la vue
    }

    /**
     * Télécharge un cahier de texte.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id)
    {
        $cahier = CahierDeTexte::findOrFail($id); // Trouver le cahier de texte par son ID
        $filePath = storage_path('app/' . $cahier->chemin_fichier); // Chemin complet du fichier

        // Télécharger le fichier
        return response()->download($filePath, $cahier->nom_fichier);
    }

    /**
     * Supprime un cahier de texte.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $cahier = CahierDeTexte::findOrFail($id); // Trouver le cahier de texte par son ID

        // Supprimer le fichier du stockage
        Storage::delete($cahier->chemin_fichier);

        // Supprimer l'entrée de la base de données
        $cahier->delete();

        // Rediriger avec un message de succès
        return redirect()->route('cahier-de-texte.index')->with('success', 'Cahier de texte supprimé avec succès.');
    }
}
