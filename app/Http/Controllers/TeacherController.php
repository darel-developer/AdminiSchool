<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use HTTP_Request2;
use HTTP_Request2_Exception;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GradesImport;
use App\Models\Grade;
use App\Models\Announcement;
use App\Models\Grades;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function create()
    {
        return view('create-teacher');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'subject' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $teacher = Teacher::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subject' => $request->subject,
            'type' => 'teacher',
            'password' => Hash::make($request->password),
        ]);

        // Envoyer un SMS à l'enseignant avec les informations de connexion via Infobip
        $this->sendSmsWithInfobip($teacher, $request->password);

        return redirect()->route('login')->with('status', 'Teacher created successfully and SMS sent!');
    }

    private function sendSmsWithInfobip($teacher, $password)
    {
        $loginLink = url('/login');

        $request = new HTTP_Request2();
        $request->setUrl('https://api.infobip.com/sms/2/text/advanced');
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
                        ['to' => $teacher->phone]
                    ],
                    'text' => "Bienvenue, {$teacher->first_name} {$teacher->last_name}\n\n" .
                              "Votre compte a été correctement créer. Voici vos informations de connexion:\n" .
                              "Email: {$teacher->email}\n" .
                              "Mot de passe: {$password}\n\n" .
                              "Connectez-vous via le lien suivant: {$loginLink}",
                ]
            ]
        ]));

        try {
            $response = $request->send();
            if ($response->getStatus() == 200 || $response->getStatus() == 201) {
                Log::info('Teacher creation SMS sent successfully: ' . $response->getBody());
            } else {
                Log::error('Failed to send teacher creation SMS: ' . $response->getStatus() . ' ' . $response->getReasonPhrase());
            }
        } catch (HTTP_Request2_Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'gradesFile' => 'required|file|mimes:xlsx,xls,csv,txt',
        ]);

        $file = $request->file('gradesFile');
        $filePath = $file->store('grades');

        // Importer les données du fichier
        Excel::import(new GradesImport, $filePath);

        return back()->with('status', 'Grades uploaded successfully!');
    }

    public function showStatistics()
    {
        $statistics = Grades::select('student_name', 'matiere', DB::raw('AVG(grade) as average_grade'))
            ->groupBy('student_name', 'matiere')
            ->get();

        return view('statistics', compact('statistics'));
    }
}
