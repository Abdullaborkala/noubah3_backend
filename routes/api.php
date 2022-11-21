<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserAnswerController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/me', [AuthController::class, 'me']);

    //Quiz APIS
    Route::prefix('question')->group(function(){
        Route::post('/insert', [QuestionController::class, 'store']);
        Route::get('/all', [QuestionController::class, 'show']);
        Route::get('/edit/{id}', [QuestionController::class, 'edit']);
        Route::patch('/update/{id}', [QuestionController::class, 'update']);
        Route::delete('/delete/{id}', [QuestionController::class, 'destroy']);
    });

    Route::prefix('quiz')->group(function(){
        Route::post('/insert', [QuizController::class, 'store']);
        Route::get('/all', [QuizController::class, 'show']);
        Route::get('/edit/{id}', [QuizController::class, 'edit']);
        Route::patch('/update/{id}', [QuizController::class, 'update']);
        Route::delete('/delete/{id}', [QuizController::class, 'destroy']);
        Route::get('/todays', [QuizController::class, 'todays']);
    });

    Route::prefix('answer')->group(function(){
        Route::post('/insert', [UserAnswerController::class, 'store']);
        Route::get('/my-answeres', [UserAnswerController::class, 'allAnsweres']);

    });
});