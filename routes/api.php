<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskDashboardController;
use App\Http\Controllers\Api\InisiatifApiController;
use App\Http\Controllers\InisiatifController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::patch('/inisiatif/{id}/toggle', [InisiatifApiController::class, 'toggle']);

Route::patch('/inisiatif/{id}', [InisiatifApiController::class, 'update']);
Route::delete('/inisiatif/{id}', [InisiatifApiController::class, 'destroy']);

Route::patch('/inisiatif/toggle/{id}', [InisiatifController::class, 'toggleApi']);
