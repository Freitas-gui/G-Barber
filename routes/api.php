<?php

use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your API!
|
*/

Route::post("/user", [UserController::class, "store"])->middleware('checkage');
Route::post("/user/login", [UserController::class, "login"])->middleware('checkage');

Route::post("/service", [ServiceController::class, "store"])->middleware('checkage');
Route::get("/service", [ServiceController::class, "index"])->middleware('checkage');

Route::post("/schedule", [ScheduleController::class, "store"])->middleware('checkage');
Route::post("/schedule/index", [ScheduleController::class, "index"])->middleware('checkage');
