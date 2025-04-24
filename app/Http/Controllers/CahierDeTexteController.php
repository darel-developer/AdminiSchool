<?php

namespace App\Http\Controllers;

use App\Models\CahierDeTexte;
use Illuminate\Http\Request;
use App\Imports\CahierDeTexteImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CahierDeTexteExport; 
use Barryvdh\DomPDF\Facade\Pdf;

class CahierDeTexteController extends Controller
{
        public function index(Request $request)
    {
        $class = $request->input('class');
        $cahiers = CahierDeTexte::where('class', $class)->orderBy('date', 'desc')->get();

        return view('cahiertexte', compact('cahiers', 'class'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new CahierDeTexteImport, $request->file('fichier'));

        return redirect()->route('cahiertexte')->with('success', 'Cahier de texte importé avec succès.');
    }

    public function destroy($class)
    {
        CahierDeTexte::where('class', $class)->delete();

        return redirect()->back()->with('success', 'Cahier de texte supprimé avec succès.');
    }

    public function show($class)
    {
        // Récupérer les cahiers de texte pour la classe spécifiée
        $cahiers = CahierDeTexte::where('class', $class)->orderBy('date', 'desc')->get();

        // Vérifier si des données existent
        if ($cahiers->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun cahier de texte trouvé pour cette classe.');
        }

        // Retourner la vue avec les données
        return view('cahiertexte.show', compact('cahiers', 'class'));
    }

    public function downloadPDF($class)
    {
        // Récupérer les cahiers de texte pour la classe spécifiée
        $cahiers = CahierDeTexte::where('class', $class)->orderBy('date', 'desc')->get();

        // Vérifier si des données existent
        if ($cahiers->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun cahier de texte trouvé pour cette classe.');
        }

        // Générer le PDF
        $pdf = Pdf::loadView('pdf.cahiertexte', compact('cahiers', 'class'));

        // Télécharger le fichier PDF
        return $pdf->download("cahier_de_texte_{$class}.pdf");
    }

}
