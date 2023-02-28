<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfitController;
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
// Categories routes
Route::Post('/category', [CategoryController::class, 'addCategory']);
Route::Get('/category/{id}', [CategoryController::class, 'getCategory']);
Route::Get('/category', [CategoryController::class, 'getAllCategory']);
Route::Patch('/category/{id}', [CategoryController::class, 'editCategory']);
Route::delete('/category/{id}', [CategoryController::class, 'deleteCategory']);

// Profit routes
Route::Post('/profit', [ProfitController::class, 'addProfit']);
Route::Get('/profit/{id}', [ProfitController::class, 'getProfit']);
Route::Get('/profit', [ProfitController::class, 'getAllProfit']);
Route::Patch('/profit/{id}', [ProfitController::class, 'editProfit']);
Route::delete('/profit/{id}', [ProfitController::class, 'deleteProfit']);