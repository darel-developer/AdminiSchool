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
use App\Models\Annonces;
use App\Models\Grades;
use Illuminate\Support\Facades\DB;
use App\Models\Classe;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\TeacherCreatedMail;

class TeacherController extends Controller
{
    public function create()
    {
        $classes = Classe::all(); // Fetch all classes from the database
        return view('create-teacher', compact('classes'));
    }

    public function store(Request $request)
    {
        Log::info('Début de la création d\'un enseignant', ['data' => $request->all()]);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:teachers,email',
            'subject'    => 'required|string|max:255',
            'class_id'   => 'required|exists:classes,id',
            'password'   => 'required|string|min:6',
        ]);

        try {
            $teacher = new \App\Models\Teacher();
            $teacher->first_name = $validated['first_name'];
            $teacher->last_name = $validated['last_name'];
            $teacher->phone = $validated['phone'];
            $teacher->email = $validated['email'];
            $teacher->subject = $validated['subject'];
            $teacher->class_id = $validated['class_id'];
            $teacher->password = bcrypt($validated['password']);
            $teacher->save();

            Log::info('Enseignant enregistré en base', ['teacher_id' => $teacher->id]);

            // Envoi de l'email avec la classe Mailable
            try {
                Mail::to($teacher->email)->send(
                    new \App\Mail\TeacherCreatedMail(
                        $teacher->first_name,
                        $teacher->last_name,
                        $teacher->email,
                        $request->password
                    )
                );
                Log::info('Mail envoyé avec succès', ['email' => $teacher->email]);
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'envoi du mail', ['error' => $e->getMessage()]);
                return redirect()->route('userschool')->with('error', 'Enseignant créé mais erreur lors de l\'envoi du mail : ' . $e->getMessage());
            }

            return redirect()->route('userschool')->with('success', 'Enseignant créé et email envoyé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'enseignant', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erreur lors de la création de l\'enseignant : ' . $e->getMessage());
        }
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
        $teacher = Teacher::findOrFail($id);
        $teacher->delete(); 
        return redirect()->route('users')->with('success', 'Enseignant supprimé avec succès.');
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id); 
        $classes = Classe::all(); 
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

    // Téléchargement PDF des statistiques (à compléter selon besoin)
    public function downloadStatisticsPdf()
    {
        // Récupère les statistiques (nom élève + matière + note)
        $statistics = \App\Models\Grades::select('student_name', 'matiere', DB::raw('AVG(grade) as average_grade'))
            ->groupBy('student_name', 'matiere')
            ->get();

        // Génère le PDF à partir d'une vue dédiée qui affiche les notes
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.statistics-simple', compact('statistics'));

        return $pdf->download('liste_eleves_matieres_notes.pdf');
    }

    // Affichage de l'emploi du temps de l'enseignant (à compléter selon besoin)
    public function showSchedule()
    {
        // Affiche juste un message simple pour le moment
        return response('<h2 style="text-align:center;margin-top:40px;">Emploi du temps enseignant à venir...</h2>');
    }
}

