<?php

namespace App\Tbuy\Employee\Filters;

use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;

class EmailFilter extends Filter implements FilterContract
{

    public function handle(array $filters, Builder $query): Builder
    {
        if (array_key_exists('email', $filters) && $filters['email']) {
            $query->whereHas('user', function (Builder $builder) use ($filters) {
                $builder->where('email', '=', $filters['email']);
            });
        }

        return $query;
    }
}
