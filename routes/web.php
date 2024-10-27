<?php

use App\Http\Controllers\PurchaseReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/purchase-report', [PurchaseReportController::class, 'getSummary']);
Route::get('/purchase-history', [PurchaseReportController::class, 'getPurchaseHistory'])->name('purchase.history');
Route::get('/get-trends-data', [PurchaseReportController::class, 'getTrendsData'])->name('trends.data');

