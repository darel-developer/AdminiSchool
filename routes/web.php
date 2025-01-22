<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

Route::post('/register/traitement', [AccountController::class, 'register']);
Route::get('/schools', [AccountController::class, 'getSchools']);






Route::get('/', function () {
    return view('welcome');
});





;

Route::get('/parent', function(){
    return view ('parent');
})->name('parent');

Route::get('/schoolevenement', function(){
    return view ('schoolevenement');
})->name('schoolevenement');

Route::get('/parentpaiement', function(){
    return view ('parentpaiement');
})->name('parentpaiement');


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





