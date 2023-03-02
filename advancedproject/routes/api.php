<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RecurringController;

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
Route::group(['prefix' => 'recurrings'], function(){
    Route::get('/', [RecurringController::class, 'getAll']);
    Route::delete('/{id}', [RecurringController::class, 'delete']);
});
//Transactions
Route::group(['prefix' => 'transactions'], function(){
    Route::get('/all', [TransactionController::class, "getAll"]);
    Route::get('/income', [TransactionController::class, "getAllIncome"]);
    Route::get('/expense', [TransactionController::class, "getAllExpense"]);
    Route::get('/list', [TransactionController::class, "getAllPagination"]);
    Route::get('/list/income', [TransactionController::class, "getPaginationIncome"]);
    Route::get('/list/expense', [TransactionController::class, "getPaginationExpense"]);
    Route::get('/recurring/{id}', [TransactionController::class, "getRecurring"]);
    Route::get('/{id}', [TransactionController::class, "getById"]);
    Route::get('/monthly', [TransactionController::class, "getMonthly"]);
    Route::get('/mobile/monthly', [TransactionController::class, "getMobileMonthly"]);
    Route::get('/weekly', [TransactionController::class, "getWeekly"]);
    Route::get('/date', [TransactionController::class, "getByDate"]);
    Route::get('/latest-transactions', [TransactionController::class, "getLatestTransactions"]);
    Route::get('/incomes', [TransactionController::class, "getIncome"]);
    Route::get('/expenses', [TransactionController::class, "getExpense"]);
    Route::get('/mobile/weekly', [TransactionController::class, "getMobileWeekly"]);
    Route::get('/yearly', [TransactionController::class, "getYearly"]);
    Route::get('/mobile/yearly', [TransactionController::class, "getMobileYearly"]);
    Route::get('/records/category/yearly', [TransactionController::class, "getYearCategoryRecords"]);
    Route::get('/records/category/monthly', [TransactionController::class, "getMonthCategoryRecords"]);
    Route::get('/records/category/daily', [TransactionController::class, "getDayCategoryRecords"]);

    Route::post('/create/fixed', [TransactionController::class, "createFixed"]);
    Route::post('create/recurring', [TransactionController::class, "createRecurring"]);

    Route::put('/edit/fixed/{id}', [TransactionController::class, "updateFixed"]);
    Route::put('/edit/recurring/{id}', [TransactionController::class, "updateRecurring"]);
    Route::put('/edit/Allrecurring/{id}', [TransactionController::class, "updateAllRecurring"]);

    Route::delete('/{id}', [TransactionController::class, "delete"]);
    Route::delete('/delete/recurring/{id}', [TransactionController::class, "deleteRecurring"]);
});
