<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Tuteur;
use HTTP_Request2;
use HTTP_Request2_Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

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
        $paiement->etat = $request->input('etat');
        $paiement->save();

        // Send SMS notification
        $this->sendSmsNotification($paiement);

        return redirect()->back()->with('success', 'Paiement mis à jour avec succès.');
    }

    private function sendSmsNotification($paiement)
    {
        $tuteur = Tuteur::where('nom', $paiement->nom)->where('prenom', $paiement->prenom)->first();
        if (!$tuteur) {
           \Log::error('Tuteur not found for paiement ID: ' . $paiement->id);
            return;
        }

        $phoneNumber = $tuteur->phone_number;

        $request = new HTTP_Request2();
        $request->setUrl('https://wgyxxq.api.infobip.com/sms/2/text/advanced');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
            'Authorization' => 'App ' . env('INFOBIP_API_KEY'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ));
        $request->setBody(json_encode([
            'messages' => [
                [
                    'from' => 'AdminiSchool',
                    'destinations' => [
                        [
                            'to' => $phoneNumber,
                        ],
                    ],
                    'text' => 'Votre paiement a été mis à jour. État: ' . $paiement->etat,
                ],
            ],
        ]));

        try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
                \Log::info('SMS notification sent successfully: ' . $response->getBody());
            } else {
                //\Log::error('Failed to send SMS notification: ' . $response->getStatus() . ' ' . $response->getReasonPhrase());
            }
        } catch (HTTP_Request2_Exception $e) {
            \Log::error('Error: ' . $e->getMessage());
        }
    }

    private function formatPhoneNumber($phoneNumber)
{
    // Ensure the phone number starts with a plus sign and country code
    if (substr($phoneNumber, 0, 1) !== '+') {
        // Add your country code here, e.g., +1 for the United States
        $phoneNumber = '+237' . $phoneNumber;
    }
    return $phoneNumber;
}
}