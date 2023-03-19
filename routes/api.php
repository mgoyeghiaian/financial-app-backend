<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecurringController;
use App\Http\Controllers\ProfitgoalController;
use App\Http\Controllers\FixedController;
use App\Http\Controllers\ReportController;

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

// CRUD For Recurring
Route::Post('/recurring',[RecurringController::class,'addRecurring']);
Route::Get('/recurring/{id}',[RecurringController::class,'getRecurring']);
Route::Get('/recurring',[RecurringController::class,'getRecurringAll']);
Route::Get('/recurringt',[RecurringController::class,'calculateProfit']);
Route::Get('/recurringf',[RecurringController::class,'getRecurringFilter']);
Route::Patch('/recurring/{id}',[RecurringController::class,'editRecurring']);
Route::Delete('/recurring/{id}',[RecurringController::class,'deleteRecurring']);
// CRUD For Profitgoal
Route::Post('/profitgoal',[ProfitgoalController::class,'addProfitgoal']);
Route::Get('/profitgoal/{id}',[ProfitgoalController::class,'getProfitgoal']);
Route::Get('/profitgoal',[ProfitgoalController::class,'getProfitgoalAll']);
Route::Get('/profitgoalf',[ProfitgoalController::class,'calculateProfit']);
Route::Patch('/profitgoal/{id}',[ProfitgoalController::class,'editProfitgoal']);
Route::Delete('/profitgoal/{id}',[ProfitgoalController::class,'deleteProfitgoal']);
// CRUD For fixed
Route::Post('/fixed',[FixedController::class,'addFixed']);
Route::Get('/fixed/{id}',[FixedController::class,'getFixed']);
Route::Get('/fixed',[FixedController::class,'getFixedAll']);
Route::Get('/fixedf',[FixedController::class,'getFixedFilter']);
Route::Delete('/fixed/{id}',[FixedController::class,'deleteFixed']);
Route::Patch('/fixed/{id}',[FixedController::class,'editFixed']);
// CRUD For report
Route::Post('/report',[ReportController::class,'addReport']);
Route::Get('/report/{id}',[ReportController::class,'getReport']);
Route::Get('/report',[ReportController::class,'getReportAll']);
Route::Delete('/report/{id}',[ReportController::class,'deleteReport']);
Route::Patch('/report/{id}',[ReportController::class,'editReport']);
Route::Get('/reportc',[ReportController::class,'calculatereport']);
// CRUD For Login Logut
Route::post('/logout', [AdminController::class, 'logout']);
Route::post('/login', [AdminController::class, 'login']);
Route::get('/users', [AdminController::class, 'allUsers']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/prot/adm', [AdminController::class, 'redirect']);
    Route::put('/users/{id}', [AdminController::class, 'update']);
Route::delete('/users/{id}', [AdminController::class, 'delete']);
Route::post('/register', [AdminController::class, 'register']);


});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
