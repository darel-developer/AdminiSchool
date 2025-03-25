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
        $students = Student::with('classe')->get();
        return view('notificationschool', compact('students'));
    }

    public function getElevesByClasse(Request $request)
    {
        $classeNom = $request->query('classe_nom');
        $classe = Classe::where('name', $classeNom)->first();

        if ($classe) {
            $eleves = Student::where('class', $classe->name)->get(); // Utilisez 'name' comme clé
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
                $message = $motif == 'absence' ? 
                    "Votre enfant {$eleve->name} est absent aujourd'hui. Type: {$type}, Heure: {$heure}." : 
                    "Votre enfant {$eleve->name} est convoqué pour une réunion. Motif: {$type}, Heure: {$heure}.";
        
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
            } else {
                Log::warning("Aucun tuteur trouvé pour l'élève {$eleve->name}");
            }
        }

        return redirect()->back()->with('success', 'Notifications envoyées avec succès!');
    }
}