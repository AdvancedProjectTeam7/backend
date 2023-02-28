<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Htpp\Controllers\ControllerTransaction;

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

Route::group(['prefix' => 'transactions'], function(){
    Route::get('/all', [ControllerTransaction::class, "getAll"]);
    Route::get('/income', [ControllerTransaction::class, "getAllIncome"]);
    Route::get('/expense', [ControllerTransaction::class, "getAllExpense"]);
    Route::get('/list', [ControllerTransaction::class, "getAllPagination"]);
    Route::get('/list/income', [ControllerTransaction::class, "getPaginationIncome"]);
    Route::get('/list/expense', [ControllerTransaction::class, "getPaginationExpense"]);
    Route::get('/recurring/{id}', [ControllerTransaction::class, "getRecurring"]);
    Route::get('/{id}', [ControllerTransaction::class, "getById"]);
    Route::get('/monthly', [ControllerTransaction::class, "getMonthly"]);
    Route::get('/mobile/monthly', [ControllerTransaction::class, "getMobileMonthly"]);
    Route::get('/weekly', [ControllerTransaction::class, "getWeekly"]);
});