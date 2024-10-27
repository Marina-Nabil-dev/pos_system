<?php

use App\Http\Controllers\PurchaseReport\GetPurchaseHistoryController;
use App\Http\Controllers\PurchaseReport\GetPurchaseTrendsDataController;
use App\Http\Controllers\PurchaseReport\GetSummaryCardsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('purchase-report')->group(function () {
    Route::get('/', GetSummaryCardsController::class);

    Route::get('trends-data', GetPurchaseTrendsDataController::class)->name('purchase.trends');

    Route::get('purchase-history', GetPurchaseHistoryController::class)->name('purchase.history');

});
