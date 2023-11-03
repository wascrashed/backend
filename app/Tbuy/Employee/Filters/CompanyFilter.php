<?php

namespace App\Tbuy\Employee\Filters;

use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;

class CompanyFilter extends Filter implements FilterContract
{

    public function handle(array $filters, Builder $query): Builder
    {
        if (array_key_exists('company_id', $filters) && $filters['company_id']) {
            $query->where('company_id', '=', $filters['company_id']);
        }

        return $query;
    }
}
