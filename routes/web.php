<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuranQuizController;
use App\Http\Controllers\SajdaAyahController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SavedAyahController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\PrayerTimeController;
use App\Http\Controllers\MosqueController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Asosiy sahifa
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// Sajda oyatlari
Route::get('/sajda-oyatlari', [SajdaAyahController::class, 'show'])->name('sajda.ayahs');

// Contact form
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Auth routes
Auth::routes();

// Faqat login bo‘lganlar uchun
Route::middleware(['auth'])->group(function () {
    Route::post('/save-ayah', [SavedAyahController::class, 'store']);
    Route::get('/saved-ayahs', [SavedAyahController::class, 'index'])->name('saved.ayahs');
    Route::delete('/saved-ayahs/{id}', [SavedAyahController::class, 'destroy']);
    
    Route::get('/quiz', [QuranQuizController::class, 'show'])->name('quran.quiz');
    Route::post('/quiz/generate', [QuranQuizController::class, 'generate'])->name('quran.quiz.generate');
    Route::post('/quiz/record-score', [QuranQuizController::class, 'recordScore'])->name('quran.quiz.record');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/search', [MessageController::class, 'search'])->name('messages.search');
    Route::get('/messages/live-search', [MessageController::class, 'liveSearch'])->name('messages.live-search');
    Route::get('/messages/chat/{userId}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::get('/messages/fetch/{userId}', [MessageController::class, 'getNewMessages'])->name('messages.fetch');
    Route::post('/messages/send', [MessageController::class, 'store'])->name('messages.send');
});

// Quran routes
Route::get('/surahs', [QuranController::class, 'index'])->name('quran.index');
Route::get('/surah/{id}', [QuranController::class, 'show'])->name('quran.show');
Route::get('/sajda-ayahs-list', [QuranController::class, 'sajda'])->name('quran.sajda');
Route::get('/quran/search', [QuranController::class, 'search'])->name('quran.search');

// Prayer Times
Route::get('/prayer-times', [PrayerTimeController::class, 'index'])->name('prayer.index');
Route::post('/prayer-times/region', [PrayerTimeController::class, 'setRegion'])->name('prayer.region');

// Mosques
Route::get('/mosques', [MosqueController::class, 'index'])->name('mosques.index');

// Contest
Route::get('/contest', [ContestController::class, 'index'])->name('contest.index');
Route::post('/contest/join', [ContestController::class, 'join'])->name('contest.join');
