<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentsController;
use App\Http\Controllers\UserController;

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

Route::prefix("auth")->group(function () {
    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/register/approve",[AuthController::class, "register_approve"]);
    Route::post("/login", [AuthController::class, "login"]);
});

Route::prefix("user")->middleware('auth:sanctum')->group(function () {
    Route::get("/", [UserController::class, 'get']);
});

Route::prefix("residents")->middleware('auth:sanctum')->group(function () {
   Route::get("/", [ResidentsController::class, "get"]);
   Route::post("/generate_key", [ResidentsController::class, "generate_key"]);
});

Route::get('/approve_key/{hash}', [ResidentsController::class, "approve_key"]);
