<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('user.verify'); 
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
