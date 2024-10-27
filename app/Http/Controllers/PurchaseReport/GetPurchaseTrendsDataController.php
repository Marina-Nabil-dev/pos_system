<?php

namespace App\Http\Controllers\PurchaseReport;

use App\Http\Controllers\Controller;
use App\Models\Purchase;

class GetPurchaseTrendsDataController extends Controller
{
    public function __invoke()
    {
        $trends = Purchase::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $trends->pluck('date')->toArray();
        $data = $trends->pluck('total')->toArray();

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
