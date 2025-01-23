<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TuteurController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

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

Route::get('/parentpaiement', function(){
    return view ('parentpaiement');
})->name('parentpaiement');



Route::get('SchoolRegister', function(){
    return view ('SchoolRegister');
})->name('SchoolRegister');

Route::get('/school', function(){
    return view ('school');
})->name('school');

Route::get('/schoolevenement', function(){
    return view ('schoolevenement');
})->name('schoolevenement');







Route::get('/pasword', function(){
    return view ('password');
})->name('password');

Route::get('/login', function(){
    return view ('login');
})->name('login');




