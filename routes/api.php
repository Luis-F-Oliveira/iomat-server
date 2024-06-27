<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolesOnUsersController;
use App\Http\Controllers\ServantController;

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

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class); 
    Route::get('entrycode', [UserController::class, 'entry_code']); 
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('rolesonusers', RolesOnUsersController::class);
    Route::get('permissions', [RolesOnUsersController::class, 'roles']);
    Route::get('permissions/{id}', [RolesOnUsersController::class, 'get_permissions']);
    Route::delete('permissions/{id}', [RolesOnUsersController::class, 'delete_permissions']);
    Route::apiResource('servants', ServantController::class);
});
