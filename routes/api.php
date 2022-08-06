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

Route::post("/user", [UserController::class, "store"]);
Route::post("/user/login", [UserController::class, "login"]);

Route::post("/service", [ServiceController::class, "store"]);
Route::get("/service", [ServiceController::class, "index"]);

Route::post("/schedule", [ScheduleController::class, "store"]);
Route::post("/schedule/index", [ScheduleController::class, "index"]);
