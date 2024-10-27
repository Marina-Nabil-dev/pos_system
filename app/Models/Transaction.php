<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => TransactionTypeEnum::class
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
