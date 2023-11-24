<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\OrganizationController;

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
Route::get("status", function() {return response("", 200);});
Route::prefix("user")->middleware('auth:sanctum')->group(function () {
    Route::get("/", [UserController::class, 'get']);
    Route::put("/", [UserController::class, 'update']);
});
Route::prefix("residents")->middleware('auth:sanctum')->group(function () {
   Route::get("/", [ResidentsController::class, "get"]);
   Route::get("/invitations", [ResidentsController::class, "get_invitations"]);
   Route::post("/generate_key", [ResidentsController::class, "generate_key"]);
   Route::put("/", [ResidentsController::class, "update"]);
});

Route::prefix("organizations")->group(function() {
    Route::get("/", [OrganizationController::class, "index"]);
});

Route::prefix("bookings")->group(function() {
   Route::post("/", [BookingsController::class, "create"]);
   Route::get("/", [BookingsController::class, "get"]);
   Route::middleware('auth:sanctum')->get("/all", [BookingsController::class, "index"]);
   Route::middleware('auth:sanctum')->put("/", [BookingsController::class, "update"]);
   Route::middleware('auth:sanctum')->post('/accept', [BookingsController::class, "accept"]);
   Route::middleware('auth:sanctum')->get('/excursions', [BookingsController::class, "excursions"]);
});

Route::get('/approve_key/{hash}', [ResidentsController::class, "approve_key"]);
Route::get('/decline_key/{hash}', [ResidentsController::class, "decline_key"]);
