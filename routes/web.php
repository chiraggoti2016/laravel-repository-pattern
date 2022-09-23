<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CpuCountController;
use App\Http\Controllers\CpuUsageController;
use App\Http\Controllers\OptionsPacksController;
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
Route::post('admin/project/{slug}/upload/cpu-count', [CpuCountController::class, 'index']);
Route::post('admin/project/{slug}/upload/cpu-usage', [CpuUsageController::class, 'index']);
Route::post('admin/project/{slug}/upload/options-packs', [OptionsPacksController::class, 'index']);

Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('user.verify'); 
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
