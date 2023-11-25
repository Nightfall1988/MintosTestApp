<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('firstPage');
});

// Route::middleware('auth')->get('home', function() {
//     return view('home');
// });

Route::post('/createAccount', function () {
    return view('createAccount');
})->middleware('auth');

Route::get('/home', [ProfileController::class, 'show'])->middleware('auth');
Route::get('/create-account', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/save', [ProfileController::class, 'store'])->middleware('auth');
Route::post('/account/{id}',  [AccountController::class, 'show'])->middleware('auth');
Route::post('/verified-transaction', [TransactionController::class, 'send']);
Route::post('/approve-transaction', [TransactionController::class, 'verify'])->middleware('auth');
Route::post('/stock-options', [AccountController::class, 'stocks'])->middleware('auth');
Route::get('/get-balance/{id}', [AccountController::class, 'balance'])->middleware('auth');
Route::get('/get-reciever-currency/{id}', [TransactionController::class, 'getRecieverCurrency'])->middleware('auth');
Route::get('/transaction-history/{id}', [TransactionController::class, 'show'])->middleware('auth');

