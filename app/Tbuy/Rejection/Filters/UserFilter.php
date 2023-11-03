<?php

namespace App\Tbuy\Rejection\Filters;

use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class UserFilter extends Filter implements FilterContract
{
    public function handle(array $filters, Builder $query): Builder
    {
        $query->when(
            isset($filters['user']),
            fn(EloquentBuilder $builder) => $builder->where('user_id', $filters['user'])
        );

        return $query;
    }
}

