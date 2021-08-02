<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;

use Illuminate\Support\Facades\Route;
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

//register user
Route::post('user/store', [UserController::class, 'store']);

//register transaction
Route::post('transaction/store', [TransactionController::class, 'store']);
