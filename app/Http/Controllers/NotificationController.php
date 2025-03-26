<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Student;
use App\Models\Tuteur;
use Illuminate\Support\Facades\Log;
use HTTP_Request2;
use HTTP_Request2_Exception;

class NotificationController extends Controller
{
    public function index()
    {
        $students = Student::with('classe')->get();
        return view('studentschool', compact('students'));
    }

    public function getElevesByClasse(Request $request)
    {
        $classeNom = $request->query('classe_nom');
        $classe = Classe::where('name', $classeNom)->first();

        if ($classe) {
            $eleves = Student::where('class', $classe->name)->get();
            return response()->json($eleves);
        }

        return response()->json([], 404);
    }

    public function send(Request $request)
    {
        $request->validate([
            'eleves' => 'required|array',
            'motif' => 'required|string|in:absence,convocation',
            'type' => 'required|string',
            'heure' => 'required|string',
        ]);

        $eleves = Student::whereIn('id', $request->eleves)->get();
        $motif = $request->motif;
        $type = $request->type;
        $heure = $request->heure;

        foreach ($eleves as $eleve) {
            $parent = $eleve->tuteur;
            if ($parent) {
                $message = $motif == 'absence' 
                    ? "Votre enfant {$eleve->name} est absent aujourd'hui. Type: {$type}, Heure: {$heure}." 
                    : "Votre enfant {$eleve->name} est convoqué pour une réunion. Motif: {$type}, Heure: {$heure}.";

                $this->sendSmsNotification($parent->phone, $message);
            } else {
                Log::warning("Aucun tuteur trouvé pour l'élève {$eleve->name}");
            }
        }

        return redirect()->back()->with('success', 'Notifications envoyées avec succès!');
    }

    private function sendSmsNotification($phoneNumber, $message)
    {
        $request = new HTTP_Request2();
        $request->setUrl('https://wgyxxq.api.infobip.com/sms/2/text/advanced');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig([
            'follow_redirects' => true,
        ]);
        $request->setHeader([
            'Authorization' => 'App ' . env('INFOBIP_API_KEY'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
        $request->setBody(json_encode([
            'messages' => [
                [
                    'from' => 'AdminiSchool',
                    'destinations' => [
                        [
                            'to' => $phoneNumber,
                        ],
                    ],
                    'text' => $message,
                ],
            ],
        ]));

        try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
                Log::info('SMS envoyé avec succès: ' . $response->getBody());
            } else {
                Log::error('Erreur lors de l\'envoi de la notification SMS: ' . $response->getStatus() . ' ' . $response->getReasonPhrase());
            }
        } catch (HTTP_Request2_Exception $e) {
            Log::error('Erreur: ' . $e->getMessage());
        }
    }
}