<?php

namespace App\Tbuy\Company\Enums;

enum CompanyType: string
{
    case SALES = 'sales';
    case SERVICES = 'services';

    public function isServices(): bool
    {
        return $this->value === self::SERVICES->value;
    }
}
