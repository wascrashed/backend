<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Query\Builder;

trait FilterTrait
{
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach ($this->filters as $filter => $column) {
            (new $filter($column))->handle($filters, $query);
        }

        return $query;
    }
}
