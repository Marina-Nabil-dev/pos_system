<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseProductPivot extends Model
{
    use SoftDeletes;
    protected $table = 'purchase_products';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id','id');
    }
}
