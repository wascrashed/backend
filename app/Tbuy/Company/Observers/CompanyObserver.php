<?php

namespace App\Tbuy\Company\Observers;

use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Filial\Models\Filial;
use Illuminate\Support\Str;

class CompanyObserver
{
    public function creating(Company $company): void
    {
        $company->registered_at = now();
        $company->slug = Str::slug($company->slug);
    }

    public function updating(Company $company): void
    {
        if ($company->isDirty('slug')) {
            $company->slug = Str::slug($company->slug);
        }
    }

    public function deleting(Company $company): void
    {
        $company->brands->each(fn(Brand $brand) => $brand->delete());
        $company->children->each(fn(Company $company) => $company->delete());
        $company->filials->each(fn(Filial $filial) => $company->delete());
    }
}
