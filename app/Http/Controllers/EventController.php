<?php




namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;



class EventController extends Controller
{
    public function create()
    {
        $classes = \App\Models\Classe::all(); // Fetch all classes from the database
        return view('eventschool', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'event_date' => 'required|date',
            'event_time' => 'required|date_format:H:i',
            'class' => 'required|string|max:255',
        ]);
    
        // Create the event
        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'class' => $request->class,
        ]);
    
        // Fetch all students in the selected class
        $students = \App\Models\Student::where('class', $request->class)->get();
    
        foreach ($students as $student) {
            // Find the parent (tuteur) of the student
            $parent = \App\Models\Tuteur::where('child_name', $student->name)->first();
    
            if ($parent) {
                // Prepare the SMS message
                $message = "Événement: {$event->title}\n"
                    . "Description: {$event->description}\n"
                    . "Date: {$event->event_date}\n"
                    . "Heure: {$event->event_time}\n"
                    . "Classe: {$event->class}";
    
                // Send the SMS
                $this->sendSmsNotification($parent->phone_number, $message);
            } else {
                Log::warning("Aucun tuteur trouvé pour l'élève {$student->name}");
            }
        }
    
        return redirect()->back()->with('success', 'Événement créé et notifications envoyées avec succès!');
    }


    private function sendSmsNotification($phoneNumber, $message)
{
    $request = new \HTTP_Request2();
    $request->setUrl('https://wgyxxq.api.infobip.com/sms/2/text/advanced');
    $request->setMethod(\HTTP_Request2::METHOD_POST);
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
            Log::info("SMS envoyé avec succès à {$phoneNumber}: {$message}");
        } else {
            Log::error("Erreur lors de l'envoi du SMS à {$phoneNumber}: " . $response->getReasonPhrase());
        }
    } catch (\HTTP_Request2_Exception $e) {
        Log::error("Erreur lors de l'envoi du SMS: " . $e->getMessage());
    }
}
}
