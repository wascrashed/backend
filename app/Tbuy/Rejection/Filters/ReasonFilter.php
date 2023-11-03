<?php

namespace App\Tbuy\Rejection\Filters;

use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Arr;

class ReasonFilter extends Filter implements FilterContract
{
    public function handle(array $filters, Builder $query): Builder
    {
        $column = $this->column ?? 'reason_id';

        if (isset($filters['reason'])) {

            $reason = Arr::wrap($filters['reason']);

            $query->whereIn($column, $reason);
        }

        return $query;
    }
}
