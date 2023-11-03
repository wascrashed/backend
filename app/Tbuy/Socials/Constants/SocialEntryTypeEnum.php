<?php

namespace App\Tbuy\Socials\Constants;

use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Company\Models\Company;

enum SocialEntryTypeEnum: string
{
    case BRAND = Brand::class;
    case COMPANY = Company::class;
}
