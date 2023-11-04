<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SoldierController;
use App\Http\Controllers\UserController;
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

//Auth
Route::get('/registration', [AuthController::class, 'registrationView'])->name('registrationView');
Route::post('/registration', [AuthController::class, 'registration'])->name('registration');
Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/profile/{userid}', [AuthController::class, 'profile'])->name('profile');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Verification (user side)
Route::get('/verification', [VerificationController::class, 'verificationView'])->name('verification');
Route::post('/verification/{userid}', [VerificationController::class, 'verificationSave'])->name('verify');

// Verification (admin side)
Route::get('/verification-requests', [AdminController::class, 'viewVerificationRequests'])->name('verification-requests');
Route::get('/verification-request/{id}', [AdminController::class, 'viewVerification'])->name('view-verification');
Route::post('/verification-request/{id}/approve', [AdminController::class, 'approveVerification'])->name('approve-verification');
Route::post('/verification-request/{id}/disapprove', [AdminController::class, 'disapproveVerification'])->name('disapprove-verification');
Route::post('/verification-request/{id}/waiting', [AdminController::class, 'verificationToWaiting'])->name('verification-to-waiting');
Route::post('/verification-request/{id}/remove', [AdminController::class, 'removeVerification'])->name('remove-verification');

// Post ask for equipment (soldier side)
Route::get('/post-ask/form', [SoldierController::class, 'form_postAsk'])->name('form_post-ask');
Route::post('/post-ask/create/{userid}', [SoldierController::class, 'create_postAsk'])->name('create_post-ask');

// Post for collecting money (soldier side)
Route::get('/post-fundraising/form', [SoldierController::class, 'form_postFundraising'])->name('form_post-fundraising');
Route::post('/post-fundraising/create/{userid}', [SoldierController::class, 'create_postFundraising'])->name('create_post-fundraising');

// Post for bids (user side)
Route::get('/post-bid/form', [UserController::class, 'form_postBid'])->name('form_post-bid');
Route::post('/post-bid/create/{userid}', [UserController::class, 'create_postBid'])->name('create_post-bid');
Route::post('/post-bid/createFree/{userid}', [UserController::class, 'create_postBidFree'])->name('create_post-bidFree');

