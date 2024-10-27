<?php

namespace App\Enums;

use App\traits\EnumHelper;

enum TransactionTypeEnum : string
{
 use EnumHelper;

Case OPEN_STOCK = 'open_stock';
Case PURCHASE = 'purchase';
Case SELL = 'sell';
Case SELL_RETURN = 'sell_return';
Case PURCHASE_RETURN = 'purchase_return';
Case ADJUSTMENT = 'adjustment';
}
