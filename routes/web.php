<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Home Route(redirect to login and signup)
Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/signup', function () {
    return view('signup');
})->name('signup');

  
// Login Route and signup route
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/signup', [LoginController::class, 'signup'])->name('signup');

Route::middleware(['auth:login','prevent-back-history'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/chatView', function () {
        return view('chatView');
    })->name('chatView');
});

