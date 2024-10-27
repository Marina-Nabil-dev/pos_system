<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum PurchaseTypeEnum: string
{
    use EnumHelper;
    case PURCHASE = 'purchase';
    case PURCHASE_RETURN = 'purchase_return';
}
