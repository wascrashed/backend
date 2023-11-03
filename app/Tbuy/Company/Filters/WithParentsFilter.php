<?php

namespace App\Tbuy\Company\Filters;

use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class WithParentsFilter extends Filter implements FilterContract
{
    public function handle(array $filters, Builder $query): Builder
    {
        return $query->when(
            isset($filters['parent']) && $filters['parent'],
            fn(EloquentBuilder $builder) => $builder->doesntHave('parent')
        );
    }
}

