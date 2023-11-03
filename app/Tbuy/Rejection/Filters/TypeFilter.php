<?php

namespace App\Tbuy\Rejection\Filters;

use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class TypeFilter extends Filter implements FilterContract
{
    public function handle(array $filters, Builder $query): Builder
    {
        return $query->when(isset($filters['type']),
            fn(EloquentBuilder $builder) => $builder->where([
                'rejectionable_type' => $filters['type']
            ])
        );
    }
}
