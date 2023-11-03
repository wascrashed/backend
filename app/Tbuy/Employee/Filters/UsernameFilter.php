<?php

namespace App\Tbuy\Employee\Filters;

use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;

class UsernameFilter extends Filter implements FilterContract
{

    public function handle(array $filters, Builder $query): Builder
    {
        if (array_key_exists('username', $filters) && $filters['username']) {
            $query->where($this->column ?? 'username', $filters['username']);
        }

        return $query;
    }
}
