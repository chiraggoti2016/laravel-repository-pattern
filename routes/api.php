<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

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

Route::post('login', [Api\Auth\AuthController::class, 'login']);
Route::post('register', [Api\Auth\RegisterController::class, 'register']);
Route::post('forgot', [Api\Auth\ForgotController::class, 'forgot']);
Route::post('reset', [Api\Auth\ForgotController::class, 'reset']);
Route::get('email/resend/{user}', [Api\Auth\VerifyController::class, 'resend'])->name('verification.resend');
Route::get('email/verify/{id}', [Api\Auth\VerifyController::class, 'verify'])->name('verification.verify');; // Make sure to keep this as your route name
    
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user', [Api\Auth\AuthController::class, 'user']);

    Route::resource('partners',Api\PartnersController::class);
    Route::resource('customers',Api\CustomersController::class);
    Route::resource('users',Api\UsersController::class);
    Route::get('users',[Api\UsersController::class, 'index'])->name('users.get');
    Route::get('partners',[Api\PartnersController::class, 'index'])->name('users.get');
    Route::get('customers',[Api\CustomersController::class, 'index'])->name('users.get');
});
