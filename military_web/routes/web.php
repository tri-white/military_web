<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SoldierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FundraisingPostController;
use App\Http\Controllers\LotPostController;
use App\Http\Controllers\AskPostController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\PropositionController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//Auth
Route::get('/registration', [AuthController::class, 'registrationView'])->name('registrationView');
Route::post('/registration', [AuthController::class, 'registration'])->name('registration');
Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Fundraising posts
Route::get('/fundraising/page={page}/searchKey={searchKey}/category={category}/sort={sort}', [FundraisingPostController::class, 'index'])->name('fundraising-posts');
Route::get('/fundraising-post/{postid}', [FundraisingPostController::class, 'showPost'])->name('fundraising-post');
Route::post('/search-fund', [FundraisingPostController::class, 'search'])->name('search-fundraisings');


// Lot posts
Route::get('/lots/page={page}/searchKey={searchKey}/category={category}/sort={sort}', [LotPostController::class, 'index'])->name('lot-posts');
Route::get('/lot-post/{postid}', [LotPostController::class, 'showPost'])->name('lot-post');
Route::post('/search-lot', [LotPostController::class, 'search'])->name('search-lots');


// Ask posts
Route::get('/asks/page={page}/searchKey={searchKey}/category={category}/sort={sort}', [AskPostController::class, 'index'])->name('ask-posts');
Route::get('/ask-post/{postid}', [AskPostController::class, 'showPost'])->name('ask-post');
Route::post('/search-ask', [AskPostController::class, 'search'])->name('search-asks');

Route::get('/profile/{userid}', [UserController::class, 'profile'])->name('profile');

Route::get('/lot-post-partial/{postid}', [LotPostController::class, 'lotPostPartial'])->name('lot-post-partial');


Route::middleware(['auth'])->group(function () {
    // user profile/logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

   // Email verification
    Route::get('/email/verify', function () {
        $successMessage = 'Підтвердіть реєстрацію за інструкціями які надійшли вам на пошту';
        return redirect()->route('welcome')->with('success-email', $successMessage);
    })->name('verification.notice');

    
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
    
        return redirect()->route('welcome')->with('success','Успішно верифіковано!');
    })->middleware(['signed'])->name('verification.verify');
    
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return redirect()->back()->with('success', 'Надіслано лист верифікації!');
    })->middleware(['throttle:6,1'])->name('verification.send');

    
    Route::post('/fundraising-post/{postid}/donate', [FundraisingPostController::class, 'donate'])->name('fundraising-post-donate');

});


Route::middleware(['auth', 'verified', 'checkBan'])->group(function () {
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

        
    Route::post('/lot-post/{postid}/place-bid', [LotPostController::class, 'bid'])->name('lot-post-bid');

    Route::post('/ask-post/{postid}/{userid}/propose', [AskPostController::class, 'propose'])->name('ask-post-propose');

    Route::post('/place-bid/{postid}/{userid}', [LotPostController::class, 'placeBid'])->name('place-bid');
    Route::post('/get-free-lot/{postid}/{userid}', [LotPostController::class, 'getFreeLot'])->name('get-free-lot');
    Route::post('/accept-proposition/{propositionid}', [AskPostController::class, 'acceptProposition'])->name('accept-proposition');


    Route::get('/fundraising/edit/{postid}', [FundraisingPostController::class, 'edit'])->name('edit-fund');
    Route::post('/fundraising/remove/{postid}/{userid}', [FundraisingPostController::class, 'remove'])->name('remove-fund');

    Route::get('/ask/edit/{postid}', [AskPostController::class, 'edit'])->name('edit-ask');
    Route::post('/ask/remove/{postid}/{userid}', [AskPostController::class, 'remove'])->name('remove-ask');

    Route::get('/lot/edit/{postid}', [LotPostController::class, 'edit'])->name('edit-lot');
    Route::post('/lot/remove/{postid}/{userid}', [LotPostController::class, 'remove'])->name('remove-lot');

    Route::get('/proposition/edit/{propositionid}', [PropositionController::class, 'edit'])->name('edit-proposition');
    Route::post('/proposition/remove/{propositionid}/{userid}', [PropositionController::class, 'remove'])->name('remove-proposition');


    Route::get('/remove-lot-form/{postid}/{userid}', [LotPostController::class, 'showRemoveForm'])->name('remove-lot-form');
    Route::get('/remove-ask-form/{postid}/{userid}', [AskPostController::class, 'showRemoveForm'])->name('remove-ask-form');
    Route::get('/remove-proposition-form/{propositionid}/{userid}', [PropositionController::class, 'showRemoveForm'])->name('remove-proposition-form');
    Route::get('/remove-fundraising-form/{postid}/{userid}', [FundraisingPostController::class, 'showRemoveForm'])->name('remove-fundraising-form');
    

    Route::get('/admin/users/{user}/ban-form', [AdminController::class, 'showBanForm'])->name('admin.ban-form');
    Route::post('/admin/users/{user}/process-ban-form', [AdminController::class, 'processBanForm'])->name('admin.process-ban-form');

    Route::get('/admin/unban-user/{user}', [AdminController::class, 'unbanUser'])->name('admin.unban-user');

});