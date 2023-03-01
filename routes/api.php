<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Post('/admin',[AdminController::class,'addAdmin']);

Route::Post('/fixed',[FixedController::class,'addFixed']);
Route::Get('/fixed/{id}',[FixedController::class,'getFixed']);
Route::Get('/fixed',[FixedController::class,'getFixedAll']);
Route::Delete('/fixed/{id}',[FixedController::class,'deleteFixed']);
Route::Patch('/fixed/{id}',[FixedController::class,'editFixed']);


Route::Post('/report',[ReportController::class,'addReport']);
Route::Get('/report/{id}',[ReportController::class,'getReport']);
Route::Get('/report',[ReportController::class,'getReportAll']);
Route::Delete('/report/{id}',[ReportController::class,'deleteReport']);
Route::Patch('/report/{id}',[ReportController::class,'editReport']);
