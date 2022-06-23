<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController;

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

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/user/{token}', [AuthController::class, 'getUser']);
    Route::post('auth/update', [AuthController::class, 'update']);

    Route::prefix('todo')->group( function() {
        Route::get('/all', [TodoController::class, 'index']);
        Route::post('/store', [TodoController::class, 'store']);
        Route::put('/{id}', [TodoController::class, 'update']);
        Route::delete('/{id}', [TodoController::class, 'destroy']);
        Route::post('/edit', [TodoController::class, 'edit']);
    });
});
