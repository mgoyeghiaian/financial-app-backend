<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecurringController;
use App\Http\Controllers\ProfitgoalController;



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

Route::Post('/admin',[AdminController::class,'addAdmin']);


// CRUD For Recurring
Route::Post('/recurring',[RecurringController::class,'addRecurring']);

Route::Get('/recurring/{id}',[RecurringController::class,'getRecurring']);

Route::Get('/recurring',[RecurringController::class,'getRecurringAll']);

Route::Patch('/recurring/{id}',[RecurringController::class,'editRecurring']);

Route::Delete('/recurring/{id}',[RecurringController::class,'deleteRecurring']);

// CRUD For Profitgoal
Route::Post('/profitgoal',[ProfitgoalController::class,'addProfitgoal']);

Route::Get('/profitgoal/{id}',[ProfitgoalController::class,'getProfitgoal']);

Route::Get('/profitgoal',[ProfitgoalController::class,'getProfitgoalAll']);

Route::Patch('/profitgoal/{id}',[ProfitgoalController::class,'editProfitgoal']);

Route::Delete('/profitgoal/{id}',[ProfitgoalController::class,'deleteProfitgoal']);
