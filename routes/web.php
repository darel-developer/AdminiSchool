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
use App\Models\Document;

Route::get('/documentschool', function () {
    return view('Schooldocument');
})->name('Schooldocument');


    Route::get('/documentschool', [FichierController::class, 'index'])->name('documentschool');
    Route::get('/documents/view/{id}', [FichierController::class, 'viewDocument'])->name('school.viewDocument');
    Route::get('/documents/download/{id}', [FichierController::class, 'downloadDocument'])->name('school.downloadDocument');

  
    
    // Route pour gérer les utilisateurs
    Route::get('/tuteurschool', [TuteurController::class, 'index'])->name('tutueurschool');
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

// Route pour stocker les paiements
Route::post('/paiement', [PaiementController::class, 'store'])->name('paiement.store');



// Route pour récuperer les informations des enfants pour leurs parents
Route::get('/child/{section}', [StudentController::class, 'getChildData'])->middleware('auth:tuteur');
Route::middleware(['auth:tuteur'])->group(function () {
    // Routes qui nécessitent l'authentification du tuteur
    Route::get('/dashboard', [TuteurController::class, 'dashboard'])->name('tuteur.dashboard');
    Route::get('/parentpaiement', [TuteurController::class, 'paiement'])->name('parentpaiement');
    Route::get('/profile', [TuteurController::class, 'profile'])->name('tuteur.profile');
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



Route::get('/documents', function(){
    return view ('documents');
})->name('documents');

Route::get('/schoolevenement', function(){
    return view ('schoolevenement');
})->name('schoolevenement');

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

Route::get('password/reset', function () {
    return view('password');
})->name('password.request');

Route::post('\traitement\password', [PasswordResetController::class, 'sendResetLinkEmailWithInfobip'])->name('password');

Route::get('reset-password', function () {
    return view('reset-password');
})->name('password.reset');

Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.update');