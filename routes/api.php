<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PizzaController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\MenuItemController;
use App\Http\Controllers\API\PDFController;
use App\Http\Controllers\ExchangeRateController;

Route::post('/generate-pdf', [PDFController::class, 'generateReport']);

Route::apiResource('orders', OrderController::class);
Route::put('orders/{order}/status', [OrderController::class, 'updateStatus']);
Route::get('user-orders', [OrderController::class, 'getUserOrders']);

Route::apiResource('menu-items', MenuItemController::class);
Route::put('menu-items/{menuItem}/toggle', [MenuItemController::class, 'toggleAvailability']);

Route::apiResource('categories', CategoryController::class);
Route::apiResource('pizzas', PizzaController::class);

Route::get('/mnb/daily-rate', [ExchangeRateController::class, 'getDailyRate']);
Route::get('/mnb/monthly-rates', [ExchangeRateController::class, 'getMonthlyRates']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
