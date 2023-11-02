<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/registration', [AuthController::class, 'registrationView'])->name('registrationView');
Route::post('/registration', [AuthController::class, 'registration'])->name('registration');
Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/profile/{userid}', [AuthController::class, 'profile'])->name('profile');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/verification', [VerificationController::class, 'verificationView'])->name('verification');
Route::post('/verification/{userid}', [VerificationController::class, 'verificationSave'])->name('verify');
