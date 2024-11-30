<?php

// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


// Web routes

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('password-reset', function () {
    return view('auth.password-reset');
})->name('password.reset');

Route::get('new-password', function () {
    return view('auth.new-password');
})->name('password.newPassword');

Route::get('/token', function () {
    return csrf_token(); 
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/password-reset', [AuthController::class, 'resetPassword']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {

    // Post routes 
    Route::prefix('auth')->middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
    });
});




