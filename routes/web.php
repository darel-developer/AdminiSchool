<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TuteurController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\FichierController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SupportController;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConvocationController;
use App\Http\Controllers\AbsenceController;



// Routes pour les tuteurs
Route::middleware(['auth:tuteur'])->group(function () {
    Route::get('/parentchat', [ChatController::class, 'parentChat'])->name('parentchat');
    Route::get('/get-teachers', [ChatController::class, 'getTeachers'])->name('get.teachers');
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
    Route::get('/get-messages/{teacherId}', [ChatController::class, 'fetchMessages'])->name('get.messages');
});

// Routes pour les enseignants
Route::middleware(['auth:teacher'])->group(function () {
    Route::get('/teacher-chat', [ChatController::class, 'teacherChat'])->name('teacher.chat');
    Route::get('/get-parents', [ChatController::class, 'getParents'])->name('get.parents');
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
    Route::get('/get-messages/{parentId}', [ChatController::class, 'fetchMessages'])->name('get.messages');
});

Route::post('/grades/upload', [GradesController::class, 'upload'])->name('grades.upload');
Route::get('/eventschool', [EventController::class, 'create'])->name('eventschool');
Route::post('/events', [EventController::class, 'store'])->name('events.store');


Route::get('/api/eleves', [NotificationController::class, 'getElevesByClasse'])->name('api.eleves');
Route::post('/classes/upload', [ClasseController::class, 'ajouter_classe'])->name('school');
Route::post('/plannings/upload', [PlanningController::class, 'ajouter_planning'])->name('plannings.upload');
Route::get('/studentschool', [NotificationController::class, 'index'])->name('studentschool');
Route::post('/notifications/send', [NotificationController::class, 'send'])->name('notifications.send');

Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events', [EventController::class, 'store'])->name('events.store');

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user instanceof \App\Models\Tuteur) {
            return redirect()->route('parent');
        } elseif ($user instanceof \App\Models\School) {
            return redirect()->route('school');
        }
    }
    return view('welcome');
});

Route::get('/documentschool', function () {
    return view('Schooldocument');
})->name('Schooldocument');

//Route pour gerer les documents
Route::get('/documentschool', [FichierController::class, 'index'])->name('documentschool');
Route::get('/documents/view/{id}', [FichierController::class, 'viewDocument'])->name('school.viewDocument');
Route::get('/documents/download/{id}', [FichierController::class, 'downloadDocument'])->name('school.downloadDocument');

  
    
// Route pour gérer les utilisateurs
Route::get('/userschool', [TuteurController::class, 'index'])->name('userschool');
Route::get('/tuteurschool/edit/{id}', [TuteurController::class, 'edit'])->name('users.edit');
Route::post('/tuteurschool/update/{id}', [TuteurController::class, 'update'])->name('users.update');
Route::delete('/tuteurschool/delete/{id}', [TuteurController::class, 'destroy'])->name('users.delete');


//Route pour gérer les élèves
Route::post('student/upload', [StudentController::class, 'upload'])->name('student.upload');
Route::post('student/upload/absences', [StudentController::class, 'uploadAbsences'])->name('student.upload.absences');
Route::post('student/upload/convocations', [StudentController::class, 'uploadConvocations'])->name('student.upload.convocations');

// Route pour mettre à jour les informations des paiements
Route::get('/schoolpaiement', [PaiementController::class, 'liste_paiement'])->name('schoolpaiement');
Route::get('/paiement/{id}', [PaiementController::class, 'show'])->name('showpaiement');
Route::put('/paiement/{id}', [PaiementController::class, 'update'])->name('paiement.update');
Route::get('/parent/paiements', [PaiementController::class, 'listePaiementsParent'])->name('parent.paiements')->middleware('auth:tuteur');
Route::get('/paiements/paiement/{id}', [PaiementController::class, 'viewInvoice'])->name('paiement.facture')->middleware('auth:tuteur');

// Route pour stocker les paiements
Route::post('/paiement', [PaiementController::class, 'store'])->name('paiement.store');



// Route pour récuperer les informations des enfants pour leurs parents
Route::get('/child/{section}', [StudentController::class, 'getChildData'])->middleware('auth:tuteur');
Route::middleware(['auth:tuteur'])->group(function () {
    // Routes qui nécessitent l'authentification du tuteur
    Route::get('/dashboard', [TuteurController::class, 'dashboard'])->name('tuteur.dashboard');
    Route::get('/parentpaiement', [TuteurController::class, 'paiement'])->name('parentpaiement');
    Route::get('/profileschool', [TuteurController::class, 'setting'])->name('profileschool');
    Route::post('/profile/update', [TuteurController::class, 'updateProfile'])->name('tuteur.updateProfile');
    Route::get('/addchild', [TuteurController::class, 'showAddChildForm'])->name('addchild');
    Route::post('/register/traitement/enfant', [TuteurController::class, 'addChild'])->name('parent.addChild');
    Route::post('/upload/document', [FichierController::class, 'uploadDocument'])->name('parent.uploadDocument');
    Route::get('/parent', [TuteurController::class, 'dashboard'])->name('parent');
});

// Route pour traiter la connexion
Route::Post('/login/traitement', [AuthController::class, 'loginTraitement']);

//Route pour avoir les informations des élèves
Route::get('/student/info', [StudentController::class, 'fetchStudentInfo'])->name('student.info');

// Route pour traiter la sauvegarde des parents
Route::Post('/register/traitement/parent', [TuteurController::class, 'ajouter_parent_traitement']);

// Route pour traiter la sauvegarde des écoles
Route::Post('/register/traitement/school', [SchoolController::class, 'ajouter_school_traitement']);

//Route pour ajouter des classes
Route::post('/register/traitement/classe', [ClasseController::class, 'ajouter_classe'])->name('classes.upload');

Route::post('/plannings/upload', [PlanningController::class, 'upload'])->name('plannings.upload');

Route::get('/', function () {
    return view('welcome');
});


Route::get('/parent', function(){
    return view ('parent');
})->name('parent');

Route::get('/profile', function(){
    return view('profile');
})->name('profile');

Route::get('/ParenRegistert', function(){
    return view ('ParentRegister');
})->name('ParentRegister');



Route::get('/parentdocument', function(){
    return view ('parentdocument');
})->name('parentdocument');

Route::get('/parentpaiement', function(){
    return view ('parentpaiement');
})->name('parentpaiement');

Route::get('/parentchild', [TuteurController::class, 'showAddChildForm'])->name('parentchild');

Route::get('SchoolRegister', function(){
    return view ('SchoolRegister');
})->name('SchoolRegister');

Route::get('/school', function(){
    return view ('school');
})->name('school');

Route::get('event', function(){
    return view ('event');
})->name('event');


Route::get('/documents', function(){
    return view ('documents');
})->name('documents');

Route::get('/schoolevenement', function(){
    return view ('schoolevenement');
})->name('schoolevenement');

Route::get('notifications', function(){
    return view('notifications');
})->name('notifications');

Route::get('/schoolpaiement', [PaiementController::class, 'liste_paiement'])->name('schoolpaiement');

Route::get('/showpaiement/{id}', [PaiementController::class, 'show'])->name('showpaiement');

Route::get('/paiement', function(){
    return view ('paiement');
})->name('paiement');

Route::get('/schooldocument', function(){
    return view ('schooldocument');
})->name('schooldocument');

Route::get('/tuteurschool', function(){
    return view('tuteurschool');
})->name('tuteurschool');

Route::get('/settingsparent', function () {
    return view('settingsparent');
})->name('settingsparent');

Route::get('/pasword', function(){
    return view ('password');
})->name('password');

Route::get('/login', function(){
    return view ('login');
})->name('login');



Route::get('helpsupport', function(){
    return view ('helpsupport');
})->name('helpsupport');

Route::get('invoice', function(){
    return view ('invoice');
})->name('invoice');

Route::get('teacher', function(){
    return view ('teacher');
})->name('teacher');

Route::get('teacherchat', function(){
    return view ('teacherchat');
})->name('teacherchat');

Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

Route::get('/help-support', [SupportController::class, 'index'])->name('help.support');
Route::post('/help-support/send', [SupportController::class, 'send'])->name('help.support.send');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password', function () {
    return view('reset-password');
})->name('password.reset');
Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
Route::get('/create-teacher', [TeacherController::class, 'create'])->name('create.teacher');
Route::post('/store-teacher', [TeacherController::class, 'store'])->name('store.teacher');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/students/details', [StudentController::class, 'details'])->name('students.details');
Route::get('/teachers/details', [TeacherController::class, 'details'])->name('teachers.details');
Route::get('/convocations/details', [ConvocationController::class, 'details'])->name('convocations.details');
Route::get('/absences/details', [AbsenceController::class, 'details'])->name('absences.details');
Route::get('/paiements/details', [PaiementController::class, 'details'])->name('paiements.details');