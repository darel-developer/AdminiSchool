<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Tuteur;
use HTTP_Request2;
use HTTP_Request2_Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

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

    public function listePaiementsParent()
    {
        $tuteur = \Illuminate\Support\Facades\Auth::user();
        $paiements = Paiement::where('nom', $tuteur->nom)->where('prenom', $tuteur->prenom)->get();
        return view('parentpaiements', compact('paiements'));
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

        // Générer le PDF
        $pdfPath = $this->generateInvoicePdf($paiement);

        // Envoyer une notification par SMS
        $this->sendSmsNotification($paiement);

        // Envoyer une notification par email avec le PDF en pièce jointe
        $this->sendEmailNotification($paiement, $pdfPath);

        // Ajouter une notification pour le tuteur
        $tuteur = Tuteur::where('nom', $paiement->nom)->where('prenom', $paiement->prenom)->first();
        if ($tuteur) {
            Notification::create([
                'tuteur_id' => $tuteur->id,
                'message' => 'Votre paiement a été mis à jour. Etat : ' . $paiement->etat,
            ]);
        }

        return redirect()->route('showpaiement', $paiement->id)->with('success', 'Paiement mis à jour avec succès. Facture générée.');
    }

    private function sendSmsNotification($paiement)
    {
        $tuteur = Tuteur::where('nom', $paiement->nom)->where('prenom', $paiement->prenom)->first();
        if (!$tuteur) {
           Log::error('Tuteur not found for paiement ID: ' . $paiement->id);
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
                    'text' => 'Votre paiement a été mis à jour. Etat: ' . $paiement->etat,
                ],
            ],
        ]));

        try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
                Log::info('SMS envoyé avec succès: ' . $response->getBody());
            } else {
                Log::error('Erreur lors de l\'envoi  SMS notification: ' . $response->getStatus() . ' ' . $response->getReasonPhrase());
            }
        } catch (HTTP_Request2_Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
    }

    private function formatPhoneNumber($phoneNumber)
    {
        // S'assurer que le numérode téléphone commence bien par l'indicatif du pays
        if (substr($phoneNumber, 0, 1) !== '+') {
            
            $phoneNumber = '+237' . $phoneNumber;
        }
        return $phoneNumber;
    }

    private function generateInvoicePdf($paiement)
    {
        // Définir le chemin du répertoire
        $directoryPath = storage_path('app/public/factures');

        // Vérifier si le répertoire existe, sinon le créer
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0755, true); // Crée le répertoire avec les permissions appropriées
        }

        // Définir le chemin où enregistrer le PDF
        $filePath = $directoryPath . '/' . $paiement->id . '_facture.pdf';

        // Si le fichier existe, le supprimer pour le remplacer par une nouvelle version
        if (file_exists($filePath)) {
            unlink($filePath); // Supprime l'ancien fichier
        }

        // Charger la vue pour le PDF
        $pdf = Pdf::loadView('invoice', compact('paiement'));

        // Enregistrer le PDF sur le disque
        $pdf->save($filePath);

        return $filePath; // Retourner le chemin du fichier PDF
    }
    
    private function sendEmailNotification($paiement, $pdfContent)
    {
        $tuteur = Tuteur::where('nom', $paiement->nom)->where('prenom', $paiement->prenom)->first();
        if (!$tuteur) {
            Log::error('Tuteur not found for paiement ID: ' . $paiement->id);
            return;
        }

        $email = $tuteur->email;

        $tempFilePath = storage_path('app/facture.pdf');
        file_put_contents($tempFilePath, $pdfContent);

        $request = new HTTP_Request2();
        $request->setUrl('https://wgyxxq.api.infobip.com/email/3/send');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
            'Authorization' => 'App ' . env('INFOBIP_API_KEY'),
            'Accept' => 'application/json'
        ));

        // Utilisation de multipart/form-data pour les pièces jointes
        $request->addUpload('attachments', $tempFilePath, 'facture.pdf', 'application/pdf');
        $request->addPostParameter([
            'from' => 'darel.sanang@facsciences-uy1.cm',
            'to' => $email,
            'subject' => 'Facture mise à jour',
            'text' => 'Votre paiement a été mis à jour. Veuillez trouver la facture mise à jour en pièce jointe.',
        ]);

        try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
                Log::info('Email envoyé avec succès: ' . $response->getBody());
            } else {
                Log::error('Erreur lors de l\'envoi de l\'email: ' . $response->getStatus() . ' ' . $response->getReasonPhrase());
            }
        } catch (HTTP_Request2_Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
    }

    public function viewInvoice($id)
    {
        $paiement = Paiement::findOrFail($id);
        $filePath = storage_path('app/public/factures/' . $paiement->id . '_facture.pdf');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'La facture n\'existe pas.');
        }

        return response()->file($filePath);
    }

    public function details()
    {
        $paiements = Paiement::all();
        return view('paiements.details', compact('paiements'));
    }

    public function getNotifications()
    {
        $tuteur = Auth::user();

        if (!$tuteur) {
            return response()->json(['notifications' => []]);
        }

        $notifications = Notification::where('tuteur_id', $tuteur->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['notifications' => $notifications]);
    }

    public function downloadInvoice($id)
{
    $paiement = Paiement::findOrFail($id);
    $filePath = storage_path('app/public/factures/' . $paiement->id . '_facture.pdf');

    if (!file_exists($filePath)) {
        return redirect()->back()->with('error', 'La facture n\'existe pas.');
    }

    return response()->download($filePath, 'facture_' . $paiement->id . '.pdf');
}

}