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
use App\Models\Classe;
use Illuminate\Support\Facades\Mail;

class TeacherController extends Controller
{
    public function create()
    {
        $classes = Classe::all(); // Fetch all classes from the database
        return view('create-teacher', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:teachers,email',
            'subject' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $teacher = Teacher::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subject' => $request->subject,
            'type' => 'teacher',
            'password' => Hash::make($request->password),
            'class_id' => $request->class_id,
        ]);

        // Send email with login details
        $platformLink = url('/login');
        $emailData = [
            'name' => $teacher->first_name . ' ' . $teacher->last_name,
            'email' => $teacher->email,
            'password' => $request->password,
            'platformLink' => $platformLink,
        ];

        Mail::send('emails.teacher-login', $emailData, function ($message) use ($teacher) {
            $message->from(config('mail.from.address'), config('mail.from.name')) // Use global "From" email
                    ->to($teacher->email)
                    ->subject('Vos informations de connexion - AdminiSchool');
        });

        // Send SMS with Infobip
        $this->sendSmsWithInfobip($teacher, $request->password);

        return redirect()->route('login')->with('status', 'Teacher created successfully and email sent!');
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

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id); // Find the teacher by ID
        $teacher->delete(); // Delete the teacher
        return redirect()->route('users')->with('success', 'Enseignant supprimé avec succès.');
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id); // Find the teacher by ID
        $classes = Classe::all(); // Fetch all classes for the dropdown
        return view('edit-teacher', compact('teacher', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:teachers,email,' . $id,
            'phone' => 'required|string|max:15',
            'subject' => 'required|string|max:255',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->only('first_name', 'last_name', 'email', 'phone', 'subject', 'class_id'));

        return redirect()->route('users')->with('success', 'Enseignant mis à jour avec succès.');
    }
}
