<?php

namespace App\Http\Controllers\PurchaseReport;

use App\Enums\PurchaseTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;

class GetSummaryCardsController extends Controller
{
    public function __invoke()
    {
        $totalPurchases = Purchase::where('type', PurchaseTypeEnum::PURCHASE)->sum('amount');
        $totalPurchaseReturns = Purchase::where('type', 'purchase_return')->sum('amount');
        $currentStock = Product::sum('stock_quantity');

        return view('purchase-report.summary',
            compact([
                'totalPurchases', 'totalPurchaseReturns', 'currentStock',
            ]));
    }
}
