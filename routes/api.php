<?php

use App\Constants\RoutePatternConstant;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AppVersionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\NoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes
Route::post('auth/sign-in', [AuthController::class, 'signIn']);
Route::post('users/sign-up', [UserController::class, 'signUp']);
Route::get('app-versions/latest', [AppVersionController::class, 'getLatest']);

// Authenticated Routes
Route::middleware('auth:api')->group(function () {
    // Auth
    Route::post('auth/sign-out', [AuthController::class, 'signOut']);

    // CRUD routes for AppVersion
    Route::prefix('app-versions')->group(function () {
        Route::post('/', [AppVersionController::class, 'create']);
        Route::get('/', [AppVersionController::class, 'getPaginated']);
        Route::get('/{appVersionId}', [AppVersionController::class, 'getById'])->where('appVersionId', RoutePatternConstant::NUMERIC);
        Route::put('/{appVersionId}', [AppVersionController::class, 'update'])->where('appVersionId', RoutePatternConstant::NUMERIC);
        Route::delete('/{appVersionId}', [AppVersionController::class, 'delete'])->where('appVersionId', RoutePatternConstant::NUMERIC);
    });

    // CRUD routes for User
    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'create']);
        Route::get('/', [UserController::class, 'getPaginated']);
        Route::get('/auth', [UserController::class, 'getAuthUser']);
        Route::put('/auth/username', [UserController::class, 'updateAuthUserName']);
        Route::put('/auth/email', [UserController::class, 'updateAuthUserEmail']);
        Route::get('/{userId}', [UserController::class, 'getById'])->where('userId', RoutePatternConstant::NUMERIC);
        Route::put('/{userId}', [UserController::class, 'update'])->where('userId', RoutePatternConstant::NUMERIC);
        Route::delete('/{userId}', [UserController::class, 'delete'])->where('userId', RoutePatternConstant::NUMERIC);
    });

    // CRUD routes for Address
    Route::prefix('addresses')->group(function () {
        Route::post('/', [AddressController::class, 'create']);
        Route::get('/', [AddressController::class, 'getPaginated']);
        Route::get('/{addressId}', [AddressController::class, 'getById'])->where('addressId', RoutePatternConstant::NUMERIC);
        Route::put('/{addressId}', [AddressController::class, 'update'])->where('addressId', RoutePatternConstant::NUMERIC);
        Route::delete('/{addressId}', [AddressController::class, 'delete'])->where('addressId', RoutePatternConstant::NUMERIC);
    });

	// CRUD routes for Question
	Route::prefix('questions')->group(function () {
    	Route::post('/', [QuestionController::class, 'create']);
    	Route::get('/', [QuestionController::class, 'getPaginated']);
    	Route::get('/{questionId}', [QuestionController::class, 'getById'])->where('questionId', RoutePatternConstant::NUMERIC);
    	Route::put('/{questionId}', [QuestionController::class, 'update'])->where('questionId', RoutePatternConstant::NUMERIC);
    	Route::delete('/{questionId}', [QuestionController::class, 'delete'])->where('questionId', RoutePatternConstant::NUMERIC);
	});

	// CRUD routes for Choice
	Route::prefix('choices')->group(function () {
    	Route::post('/', [ChoiceController::class, 'create']);
    	Route::get('/', [ChoiceController::class, 'getPaginated']);
    	Route::get('/{choiceId}', [ChoiceController::class, 'getById'])->where('choiceId', RoutePatternConstant::NUMERIC);
    	Route::put('/{choiceId}', [ChoiceController::class, 'update'])->where('choiceId', RoutePatternConstant::NUMERIC);
    	Route::delete('/{choiceId}', [ChoiceController::class, 'delete'])->where('choiceId', RoutePatternConstant::NUMERIC);
	});

	// CRUD routes for Answer
	Route::prefix('answers')->group(function () {
    	Route::post('/', [AnswerController::class, 'create']);
    	Route::get('/', [AnswerController::class, 'getPaginated']);
    	Route::get('/{answerId}', [AnswerController::class, 'getById'])->where('answerId', RoutePatternConstant::NUMERIC);
    	Route::put('/{answerId}', [AnswerController::class, 'update'])->where('answerId', RoutePatternConstant::NUMERIC);
    	Route::delete('/{answerId}', [AnswerController::class, 'delete'])->where('answerId', RoutePatternConstant::NUMERIC);
	});

	// CRUD routes for Reviewer
	Route::prefix('reviewers')->group(function () {
    	Route::post('/', [ReviewerController::class, 'create']);
    	Route::get('/', [ReviewerController::class, 'getPaginated']);
    	Route::get('/{reviewerId}', [ReviewerController::class, 'getById'])->where('reviewerId', RoutePatternConstant::NUMERIC);
    	Route::put('/{reviewerId}', [ReviewerController::class, 'update'])->where('reviewerId', RoutePatternConstant::NUMERIC);
    	Route::delete('/{reviewerId}', [ReviewerController::class, 'delete'])->where('reviewerId', RoutePatternConstant::NUMERIC);
	});

	// CRUD routes for Note
	Route::prefix('notes')->group(function () {
    	Route::post('/', [NoteController::class, 'create']);
    	Route::get('/', [NoteController::class, 'getPaginated']);
    	Route::get('/{noteId}', [NoteController::class, 'getById'])->where('noteId', RoutePatternConstant::NUMERIC);
    	Route::put('/{noteId}', [NoteController::class, 'update'])->where('noteId', RoutePatternConstant::NUMERIC);
    	Route::delete('/{noteId}', [NoteController::class, 'delete'])->where('noteId', RoutePatternConstant::NUMERIC);
	});
});
