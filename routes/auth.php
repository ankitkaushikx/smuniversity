<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// These routes are for Authentication 

// Route to show the login form
Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');

// Route to handle the login form submission
Route::post('/login', [AuthController::class, 'login'])->name('login');
