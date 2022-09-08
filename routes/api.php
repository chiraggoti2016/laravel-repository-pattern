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

    Route::group(['prefix' => 'countries', 'as' => 'countries'], function () {
        Route::get('/list',[Api\CountriesController::class, 'list'])->name('.list');
    });

    Route::group(['prefix' => 'question/categories', 'as' => 'question.categories'], function () {
        Route::get('/list',[Api\CountriesController::class, 'list'])->name('.list');
    });

    Route::group(['prefix' => 'users', 'as' => 'users'], function () {
        Route::post('/email-already-exists', [Api\UsersController::class, 'emailAlreadyExists'])->name('.email-already-exists');
    });
    
    Route::group(['prefix' => 'scopes', 'as' => 'scopes'], function () {
        Route::get('/list/byslug',[Api\ScopesController::class, 'listBySlug'])->name('.listbyslug');
    });

    Route::group(['prefix' => 'scope-stages', 'as' => 'scope.stages'], function () {
        Route::get('/list/byscope',[Api\ScopeStagesController::class, 'listByScope'])->name('.listbyscope');
    });

    // Resources
    Route::resource('countries',Api\CountriesController::class);
    Route::resource('partners',Api\PartnersController::class);
    Route::resource('customers',Api\CustomersController::class);
    Route::resource('users',Api\UsersController::class);
    Route::resource('projects',Api\ProjectsController::class);
    Route::resource('questions',Api\QuestionsController::class);
    Route::resource('question/categories',Api\QuestionCategoriesController::class);
    
});
