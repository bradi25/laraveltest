<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CreditBalanceController;
use App\Http\Controllers\Api\DebitBalanceController;
use App\Http\Controllers\Api\CheckBalanceController;

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

// transaction credit
Route::post('/credit-balance', [CreditBalanceController::class, '__invoke']);
// transaction debit
Route::post('/debit-balance', [DebitBalanceController::class, '__invoke']);
// check balance
Route::get('/check-balance', [CheckBalanceController::class, '__invoke']);
