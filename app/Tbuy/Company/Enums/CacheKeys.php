<?php

namespace App\Tbuy\Company\Enums;

use App\Traits\SetKeys;

enum CacheKeys: string
{
    use SetKeys;

    case COMPANY_TAG = 'company-tag';
    case COMPANY_LIST = 'company-list';
    case COMPANY_EMPLOYEE = 'company-employee';
    case COMPANY_EMPLOYEE_LIST = 'company-employee-list';
    case COMPANY_PURCHASE_REFUND = 'company-purchase-refund';

    public static function ttl(): int
    {
        return 3600 * 24;
    }
}
