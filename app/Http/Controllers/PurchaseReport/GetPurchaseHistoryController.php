<?php

namespace App\Http\Controllers\PurchaseReport;

use App\Http\Controllers\Controller;
use App\Models\PurchaseProductPivot;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GetPurchaseHistoryController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseProductPivot::whereHas('purchase')
                ->with('product', 'purchase', 'purchase.transaction')
                ->when($request->has('type') && $request->type !== null, function ($query) use ($request) {
                    $query->whereHas('purchase.transaction', fn ($query) => $query->where('type', $request->type));
                })
                ->get()
                ->map(function ($purchaseProduct) {
                    /** @var PurchaseProductPivot $purchaseProduct */
                    return [
                        'product_name' => $purchaseProduct->product->name,
                        'transaction_type' => $purchaseProduct->purchase->transaction->type->prettifyName(),
                        'quantity' => $purchaseProduct->quantity,
                        'amount' => $purchaseProduct->price,
                        'created_at' => $purchaseProduct->purchase->created_at->format('d M, Y h:i A'),
                    ];
                });

            return DataTables::of($data)
                ->make(true);
        }
    }
}
