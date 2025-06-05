<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\OrderController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::fallback(function () {
    return view('shirt-order');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('shirt-order');
    })->name('home');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
});
