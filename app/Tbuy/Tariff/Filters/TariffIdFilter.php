<?php

namespace App\Tbuy\Tariff\Filters;

use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class TariffIdFilter extends Filter implements FilterContract
{
    public function handle(array $filters, Builder $query): Builder
    {
        $query->when(isset($filters['tariff_id']),
            fn(EloquentBuilder $builder) => $builder->where($this->column, '=', $filters['tariff_id'])
        );

        return $query;
    }
}
