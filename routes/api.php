<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Task\TaskController;

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

// User Authentication API
Route::prefix('auth')->group(function () {

    // Registration
    Route::post('register', [RegisterController::class, 'register']);

    // Login
    Route::post('login', [LoginController::class, 'login']);
});



Route::group(['middleware' => 'auth:api'], function () {

    // Get User Data
    Route::get('/user', [UserController::class, 'index']);

    // Tasks Routes
    Route::Resource('tasks', TaskController::class)->except(['index']);

    Route::get('tasks', [TaskController::class, 'index']);

    Route::post('task/{id}', [TaskController::class, 'updateTask']);

});
