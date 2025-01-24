<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;

class PaiementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'typepaiement' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'num_facture' => 'required|string|max:255',
        ]);

        $paiement = new Paiement([
            'nom' => $request->get('nom'),
            'prenom' => $request->get('prenom'),
            'typepaiement' => $request->get('typepaiement'),
            'montant' => $request->get('montant'),
            'num_facture' => $request->get('num_facture'),
            'etat' => 'en attente',
        ]);

        $paiement->save();

        return redirect()->back()->with('success', 'Paiement enregistré avec succès!');
    }

    public function liste_paiement()
    {
        $paiements = Paiement::all();
        return view('schoolpaiement', compact('paiements'));
    }

    public function show($id)
    {
        $paiement = Paiement::findOrFail($id);
        return view('showpaiement', compact('paiement'));
    }

    public function update(Request $request, $id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->etat = $request->get('etat');
        $paiement->save();

        return redirect()->route('paiement.index')->with('success', 'État du paiement mis à jour avec succès!');
    }
}