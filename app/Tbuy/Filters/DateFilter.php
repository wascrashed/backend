<?php

namespace App\Tbuy\Filters;

use Illuminate\Contracts\Database\Query\Builder;

class DateFilter extends Filter implements FilterContract
{
    public function handle(array $filters, Builder $query): Builder
    {
        if (array_key_exists('rejection_date', $filters)) {
            $query->where($this->column ?? 'date', $filters['date']);
        }

        return $query;
    }
}
