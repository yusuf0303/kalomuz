<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuranQuizController;
use App\Http\Controllers\SajdaAyahController;
use App\Http\Controllers\LoginPageController;
//use App\Http\Controllers\UserProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

// Asosiy sahifa - hammaga ochiq!
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/index', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/sajda-oyatlari', [SajdaAyahController::class, 'show'])->name('sajda.ayahs');

Route::get('/profile', function() {
    return 'User profilingiz bu yerda chiqadi!';
})->name('profile');

Route::get('/saved-ayahs', function() {
    return 'Saqlagan oyatlaringiz bu yerda chiqadi!';
})->name('saved.ayahs');


// Auth routes (bir marta)
Auth::routes();

// Faqat login bo‘lganlar uchun maxsus sahifalar
Route::middleware(['auth'])->group(function() {
//    Route::get('/my-profile', [UserProfileController::class, 'show'])->name('user-profile');
//    Route::get('/saved-ayahs', [UserProfileController::class, 'saved_ayahs'])->name('saved-ayahs');
    Route::get('/quiz', [QuranQuizController::class, 'show'])->name('quran.quiz');
    // logout POST route default Auth::routes() bilan bor
});

// Login va register sahifasi (custom dizayn uchun)
Route::get('/login', [LoginPageController::class, 'login'])->name('login')->middleware('guest');
Route::get('/register', [LoginPageController::class, 'register'])->name('register')->middleware('guest');


// YAGONA LOGOUT ROUTE. Agar Auth::routes() bor bo‘lsa, alohida kerak emas.
// Agar custom logout funksiyasi kerak bo‘lsa, mana bunday:
// Route::post('/logout', function() {
//     Auth::logout();
//     return redirect('/login');
// })->name('logout');


