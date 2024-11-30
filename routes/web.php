<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RESTController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\SOAPController;
use App\Http\Controllers\SOAPClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pizzas/{category?}', [PizzaController::class, 'index'])->name('pizzas.index');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');
Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update')->middleware('auth');

Route::get('/dashboard', [OrderController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/admin', [OrderController::class, 'admin'])->name('admin')->middleware('auth');

Route::get('/mnb', [ExchangeRateController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/restful', [RESTController::class, 'index'])->name('restful');

Route::post('/soap', [SOAPController::class, 'handle']);
Route::get('/soap/wsdl', [SOAPController::class, 'wsdl']);

Route::get('/soap', [SOAPClientController::class, 'index']);
Route::post('/soap/execute', [SOAPClientController::class, 'execute']);

require __DIR__ . '/auth.php';
