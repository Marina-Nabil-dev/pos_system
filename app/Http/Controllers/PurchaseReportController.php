<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseTypeEnum;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProductPivot;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class PurchaseReportController extends Controller
{
    public function getSummary()
    {
        $totalPurchases = Purchase::where('type', PurchaseTypeEnum::PURCHASE)->sum('amount');
        $totalPurchaseReturns = Purchase::where('type', 'purchase_return')->sum('amount');
        $currentStock = Product::sum('stock_quantity');



        $purchaseHistory = Purchase::with('products')->latest()->paginate();
        $purchaseTypes = PurchaseTypeEnum::cases();


        return view('purchase-report.summary',
            compact([
                'totalPurchases', 'totalPurchaseReturns', 'currentStock', 'purchaseHistory',
                'purchaseTypes'
            ]));
    }

    public function getTrendsData()
    {
        $trends = Purchase::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $trends->pluck('date')->toArray();
        $data = $trends->pluck('total')->toArray();

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    /**
     * @throws \Exception
     */
    public function getPurchaseHistory(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseProductPivot::whereHas('purchase')
                ->with('product','purchase','purchase.transaction')
                ->when($request->has('type') && $request->type !== null, function ($query) use ($request) {
                    $query->whereHas('purchase.transaction', fn($query) => $query->where('type', $request->type));
                })
                ->get()
                ->map(function ($purchaseProduct) {
                    /** @var PurchaseProductPivot $purchaseProduct */
                    return [
                        'product_name' => $purchaseProduct->product->name,
                        'transaction_type' => $purchaseProduct->purchase->transaction->type->prettifyName(),
                        'quantity' => $purchaseProduct->purchase->quantity,
                        'amount' => $purchaseProduct->purchase->amount,
                        'created_at' => $purchaseProduct->purchase->created_at->format('d M, Y h:i A'),
                    ];
                });

            return DataTables::of($data)
                ->make(true);
        }

    }
}
