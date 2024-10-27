<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum TransactionTypeEnum: string
{
    use EnumHelper;

    case OPEN_STOCK = 'open_stock';
    case PURCHASE = 'purchase';
    case SELL = 'sell';
    case SELL_RETURN = 'sell_return';
    case PURCHASE_RETURN = 'purchase_return';
    case ADJUSTMENT = 'adjustment';
}
