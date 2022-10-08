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
Route::any('email/resend/{user}', [Api\Auth\VerifyController::class, 'resend'])->name('verification.resend');
Route::get('email/verify/{id}', [Api\Auth\VerifyController::class, 'verify'])->name('verification.verify');; // Make sure to keep this as your route name

Route::any('project/hosts/{slug}', [Api\ProjectsController::class, 'hosts']);
Route::any('project/host-details/{slug}', [Api\ProjectsController::class, 'hostdetails']);
Route::any('project/{slug}/database-details/{id}', [Api\ProjectsController::class, 'databasedetails']);
Route::get('project/{id}/database-details', [Api\ProjectsController::class, 'specificdatabasedetails']);
Route::get('database-feature-details', [Api\ProjectsController::class, 'specificdatabasefeaturedetails']);

Route::group(['prefix' => 'projects', 'as' => 'projects'], function () {
    Route::get('/{id}',[Api\ProjectsController::class, 'show']);
});

Route::group(['prefix' => 'questions', 'as' => 'questions'], function () {
    Route::post('list/bycategory/{scope}',[Api\QuestionsController::class, 'listByCategory'])->name('.bycategory');
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user', [Api\Auth\AuthController::class, 'user']);
    Route::post('change-password', [Api\UsersController::class, 'changePassword']);    

    Route::group(['prefix' => 'countries', 'as' => 'countries'], function () {
        Route::get('/list',[Api\CountriesController::class, 'list'])->name('.list');
    });

    // Route::group(['prefix' => 'questions', 'as' => 'questions'], function () {
    //     Route::post('list/bycategory/{scope}',[Api\QuestionsController::class, 'listByCategory'])->name('.bycategory');
    // });

    Route::group(['prefix' => 'question/categories', 'as' => 'question.categories'], function () {
        Route::get('/list',[Api\QuestionCategoriesController::class, 'list'])->name('.list');
    });

    Route::group(['prefix' => 'users', 'as' => 'users'], function () {
        Route::post('/email-already-exists', [Api\UsersController::class, 'emailAlreadyExists'])->name('.email-already-exists');
        Route::post('/reset-password/{user}', [Api\UsersController::class, 'resetPassword'])->name('.reset-password');
    });
    
    Route::group(['prefix' => 'scopes', 'as' => 'scopes'], function () {
        Route::get('/list/byslug',[Api\ScopesController::class, 'listBySlug'])->name('.listbyslug');
    });

    Route::group(['prefix' => 'scope-stages', 'as' => 'scope.stages'], function () {
        Route::get('/list/byscope/{project_id}',[Api\ScopeStagesController::class, 'listByScopeProject'])->name('.listbyscope.project_id');
        Route::get('/list/byscope',[Api\ScopeStagesController::class, 'listByScope'])->name('.listbyscope');
    });

    Route::group(['prefix' => 'questionaires', 'as' => 'questionaires'], function () {
        Route::post('/send/{project_id}',[Api\QuestionairesController::class, 'send'])->name('.send');
    });

    Route::group(['prefix' => 'uploads', 'as' => 'uploads'], function () {
        Route::post('/file',[Api\UploadsController::class, 'file'])->name('.file');
    });

    Route::group(['prefix' => 'projects', 'as' => 'projects'], function () {
        Route::post('/stage-update',[Api\ProjectsController::class, 'stageUpdate'])->name('.stage-update');
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
