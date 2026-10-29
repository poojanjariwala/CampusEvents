<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

/* ---------- public site ---------- */

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->whereNumber('event')->name('events.show');
Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->whereNumber('event')->name('events.register');
Route::get('/registrations/{registration}/confirmed', [RegistrationController::class, 'success'])->whereNumber('registration')->name('registration.success');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.send');

Route::get('/feed.xml', FeedController::class)->name('feed');

/* ---------- admin panel ---------- */

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:6,1')->name('login.store');

    Route::middleware('admin')->group(function () {
        Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::resource('events', AdminEventController::class)->except('show');

        Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
        Route::get('/registrations/export', [AdminRegistrationController::class, 'export'])->name('registrations.export');
        Route::delete('/registrations/{registration}', [AdminRegistrationController::class, 'destroy'])->name('registrations.destroy');

        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });
});
