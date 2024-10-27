<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum PurchaseTypeEnum : string
{
    use EnumHelper;
    Case PURCHASE = 'purchase';
    Case PURCHASE_RETURN = 'purchase_return';
}
