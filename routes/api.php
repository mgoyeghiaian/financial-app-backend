<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

Route::get('/users', [AdminController::class, 'allUsers']);
Route::post('/register', [AdminController::class, 'register']);
Route::post('/login', [AdminController::class, 'login']);
 
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/prot/adm', [AdminController::class, 'redirect']);
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::put('/users/{id}', [AdminController::class, 'update']);
    Route::delete('/users/{id}', [AdminController::class, 'delete']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});