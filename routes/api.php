<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/students', function(){
//     return 'All Students Info API';
// });

// Public Routes
// Route::get('/students', [StudentController::class, 'index']);
// Route::get('/students/{id}', [StudentController::class, 'show']);
// Route::post('/students', [StudentController::class, 'store']);
// Route::put('/students/{id}', [StudentController::class, 'update']);
// Route::delete('/students/{id}', [StudentController::class, 'destroy']);
// Route::get('/students/search/{city}', [StudentController::class, 'search']);

// Route::resource('students', StudentController::class);

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotpassword']);


Route::post('/reset-password', [ForgotPasswordController::class, 'resetpassword']);

// protected Routes 
// Route::middleware('auth:sanctum')->get('/students', [StudentController::class, 'index']);

// Route::middleware(['auth:sanctum'])->group(function(){

//     Route::get('/students', [StudentController::class, 'index']);
//     Route::get('/students/{id}', [StudentController::class, 'show']);
//     Route::post('/students', [StudentController::class, 'store']);
//     Route::put('/students/{id}', [StudentController::class, 'update']);
//     Route::delete('/students/{id}', [StudentController::class, 'destroy']);
//     Route::get('/students/search/{city}', [StudentController::class, 'search']);
//     Route::post('/logout', [UserController::class, 'logout']);

// });

// Partailly Protected 
// Public 
Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::get('/students/search/{city}', [StudentController::class, 'search']);

// protected
Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('/students', [StudentController::class, 'store']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/students');
    })->name('verification.verify');

    Route::post('/email/verification-notification',[EmailVerificationController::class, 'resendverification']);

   


 
// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
 
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['throttle:6,1'])->name('verification.send');
    
    });


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
