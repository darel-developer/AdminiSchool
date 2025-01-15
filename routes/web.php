<?php

use App\Http\Controllers\ActeurController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;


Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');




Route::get('/', function () {
    return view('welcome');
});



Route::post('/register/traitement', [ActeurController::class, 'register_utilisateur_traitement'])->name('register_utilisateur_traitement');


Route::get('/parent', function(){
    return view ('parent');
})->name('parent');

Route::get('/school', function(){
    return view ('school');
})->name('school');



Route::get('/register', function(){
    return view ('register');
})->name('register');

Route::get('/pasword', function(){
    return view ('password');
})->name('password');

Route::get('/login', function(){
    return view ('login');
})->name('login');

Route::post('/login/traitement', [ActeurController::class, 'login_connexion'])->name('login_connexion');


