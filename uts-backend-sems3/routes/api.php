<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\employeesController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API for employees
Route::prefix('/employees')->group(function () {
    Route::get('/', [employeesController::class, 'index']); // get all employees

    Route::post('/', [employeesController::class, 'store'])->middleware('auth:sanctum'); // create new employees

    Route::get('/{id}', [employeesController::class, 'show']); // get employees by id

    Route::put('/{id}', [employeesController::class, 'update'])->middleware('auth:sanctum'); // update employees by id

    Route::delete('/{id}', [employeesController::class, 'destroy'])->middleware('auth:sanctum'); // delete employees by id


    Route::get('/search/{name}', [employeesController::class, 'search']); // search employees by name

    // route for employees status (active, inactive, terminated)
    Route::prefix('/status')->group(function () {
        Route::get('/active', [employeesController::class, 'active']); // get all active employees

        Route::get('/inactive', [employeesController::class, 'inactive']);  // get all inactive employees

        Route::get('/terminated', [employeesController::class, 'terminated']); // get all terminated employees
    });
});

// Auth API
Route::post('/register', [AuthController::class, 'register'])->name('register'); // register new user

Route::post('/login', [AuthController::class, 'login'])->name('login'); // login user