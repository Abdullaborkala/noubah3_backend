<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
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
    Route::post('/me', [AuthController::class, 'me']);

    //Quiz APIS
    Route::prefix('quiz')->group(function(){
        Route::post('/insert', [QuizController::class, 'store']);
        Route::get('/all', [QuizController::class, 'show']);
        Route::get('/edit/{id}', [QuizController::class, 'edit']);
        Route::patch('/update/{id}', [QuizController::class, 'update']);
    });

    Route::prefix('daily-quiz')->group(function(){
        Route::post('/insert', [QuizController::class, 'store']);
        Route::get('/all', [QuizController::class, 'show']);
        Route::get('/edit/{id}', [QuizController::class, 'edit']);
        Route::patch('/update/{id}', [QuizController::class, 'update']);
    });
});