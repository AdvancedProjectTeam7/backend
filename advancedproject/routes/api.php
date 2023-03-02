<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\AuthController;
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
Route::Get('/category/name/{name}', [CategoryController::class, 'getByName']);
Route::Patch('/category/{id}', [CategoryController::class, 'editCategory']);
Route::delete('/category/{id}', [CategoryController::class, 'deleteCategory']);

// Profit routes
Route::Post('/profit', [ProfitController::class, 'addProfit']);
Route::Get('/profit/{id}', [ProfitController::class, 'getProfit']);
Route::Get('/profit', [ProfitController::class, 'getAllProfit']);
Route::Patch('/profit/{id}', [ProfitController::class, 'editProfit']);
Route::delete('/profit/{id}', [ProfitController::class, 'deleteProfit']);

//Authentication routes

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

});

Route::Patch('/updateuser/{id}', [AuthController::class, 'edituser']);
Route::Get('/getuser/{id}', [AuthController::class, 'getadmin']);
Route::Get('/getall', [AuthController::class, 'getAlluser']);
Route::delete('/delete/{id}', [AuthController::class, 'deleteuser']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user-profile', [AuthController::class, 'userProfile']);
