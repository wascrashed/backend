<?php

namespace App\Tbuy\Target\Enums;

use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Models\Product;

enum Targetable: string
{
    case product = Product::class;
    case brand = Brand::class;
    case company = Company::class;

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
