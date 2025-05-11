<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Student;
use App\Models\Tuteur;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
            'date' => 'required|date',
        ]);

        $eleves = Student::whereIn('id', $request->eleves)->get();
        $motif = $request->motif;
        $type = $request->type;
        $heure = $request->heure;
        $date = $request->date;

        foreach ($eleves as $eleve) {
            $parent = $eleve->tuteur;
            if ($parent) {
                $message = $motif == 'absence' 
                    ? "Votre enfant {$eleve->name} est absent le {$date}. Type: {$type}, Heure: {$heure}." 
                    : "Votre enfant {$eleve->name} est convoqué pour une réunion le {$date}. Motif: {$type}, Heure: {$heure}.";

                // Send SMS notification
                $this->sendSmsNotification($parent->phone, $message);

                // Create in-app notification
                Notification::create([
                    'tuteur_id' => $parent->id,
                    'message' => $message,
                ]);
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

    public function getNotifications()
    {
        $userId = Auth::id();
        $notifications = Notification::where('tuteur_id', $userId)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        $notification = Notification::where('id', $id)->where('user_id', $user->id)->first();

        if ($notification && !$notification->is_read) {
            $notification->is_read = true;
            $notification->save();
        }

        $user = Auth::user();
        $unreadCount = $user ? Notification::where('user_id', $user->id)->where('is_read', false)->count() : 0;

        return response()->json(['success' => true, 'unreadCount' => $unreadCount]);
    }

    public function getUnreadNotificationCount()
    {
        $userId = Auth::id();
        $unreadNotificationsCount = Notification::where('tuteur_id', $userId)->where('is_read', false)->count();

        return response()->json(['unreadNotificationsCount' => $unreadNotificationsCount]);
    }

    public function getParentDashboard()
    {
        $userId = Auth::id(); // Récupérer l'ID de l'utilisateur connecté

        // Compter les notifications non lues
        $unreadNotificationsCount = Notification::where('tuteur_id', $userId)->where('is_read', false)->count();

        // Retourner la vue avec les données nécessaires
        return view('parent', compact('unreadNotificationsCount'));
    }
}