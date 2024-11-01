<?php

namespace App\Models;

use App\Enums\PurchaseTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => PurchaseTypeEnum::class,
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_products', 'purchase_id', 'product_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
