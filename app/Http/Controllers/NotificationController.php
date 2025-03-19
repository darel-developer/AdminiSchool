<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Student;
use App\Models\Tuteur;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        return view('notificationschool', compact('classes'));
    }

    public function getElevesByClasse(Request $request)
    {
        $classeNom = $request->query('classe_nom');
        $eleves = Student::where('class', $classeNom)->get();
        return response()->json($eleves);
    }

    public function send(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'eleves' => 'required|array',
            'motif' => 'required|string|in:absence,convocation',
        ]);

        $eleves = Student::whereIn('id', $request->eleves)->get();
        $motif = $request->motif;

        foreach ($eleves as $eleve) {
            $parent = $eleve->parent;
            $message = $motif == 'absence' ? 
                "Votre enfant {$eleve->nom} est absent aujourd'hui." : 
                "Votre enfant {$eleve->nom} est convoqué pour une réunion.";

            // Envoyer le SMS via l'API Infobip
            $response = Http::withBasicAuth('your_infobip_username', 'your_infobip_password')
                ->post('https://api.infobip.com/sms/1/text/single', [
                    'from' => 'AdminiSchool',
                    'to' => $parent->phone,
                    'text' => $message,
                ]);

            if ($response->successful()) {
                Log::info("SMS envoyé à {$parent->phone}: {$message}");
            } else {
                Log::error("Erreur lors de l'envoi du SMS à {$parent->phone}: {$response->body()}");
            }
        }

        return redirect()->back()->with('success', 'Notifications envoyées avec succès!');
    }
}