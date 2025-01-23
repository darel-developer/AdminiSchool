<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TuteurController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ChatController;


//Route pour l'envoi et reception des messages
Route::post('/api/send-message', [ChatController::class, 'sendMessage']);
Route::get('/api/fetch-messages', [ChatController::class, 'fetchMessages']);
Route::post('/api/school/send-message', [ChatController::class, 'sendMessageFromSchool']);
Route::get('/api/school/fetch-messages/{tuteurId}', [ChatController::class, 'fetchMessages']);
Route::post('/api/school/send-message', [ChatController::class, 'sendMessage']);



//Route pour récuperer les informations des enfants pour leurs parents
Route::get('/child/{section}', [StudentController::class, 'getChildData'])->middleware('auth');
Route::middleware(['auth:tuteur'])->group(function () {
    // Routes qui nécessitent l'authentification du tuteur
    Route::get('/dashboard', [TuteurController::class, 'dashboard'])->name('tuteur.dashboard');
    Route::get('/parentpaiement', [TuteurController::class, 'paiement'])->name('parentpaiement');
    Route::get('/profile', [TuteurController::class, 'profile'])->name('tuteur.profile');
    // Ajoutez d'autres routes protégées ici
});

//route pour traiter la connexion
Route::Post('/login/traitement', [AuthController::class, 'loginTraitement']);

Route::get('/student/info', [StudentController::class, 'fetchStudentInfo'])->name('student.info');

//route pour traiter la sauvegarde des parents
Route::Post('/register/traitement/parent', [TuteurController::class, 'ajouter_parent_traitement']);

//route pour traiter la sauvegarde des écoles
Route::Post('/register/traitement', [SchoolController::class, 'ajouter_school_traitement']);





Route::get('/', function () {
    return view('welcome');
});






;

Route::get('/parent', function(){
    return view ('parent');
})->name('parent');

Route::get('/ParenRegistert', function(){
    return view ('ParentRegister');
})->name('ParentRegister');

Route::get('/parentchat', function(){
    return view ('parentchat');
})->name('parentchat');



Route::get('/parentpaiement', function(){
    return view ('parentpaiement');
})->name('parentpaiement');



Route::get('SchoolRegister', function(){
    return view ('SchoolRegister');
})->name('SchoolRegister');

Route::get('/school', function(){
    return view ('school');
})->name('school');

Route::get('/schoolchat', function(){
    return view ('schoolchat');
})->name('schoolchat');

Route::get('/schoolevenement', function(){
    return view ('schoolevenement');
})->name('schoolevenement');







Route::get('/pasword', function(){
    return view ('password');
})->name('password');

Route::get('/login', function(){
    return view ('login');
})->name('login');




