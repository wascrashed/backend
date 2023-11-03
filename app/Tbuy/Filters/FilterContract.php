<?php

namespace App\Tbuy\Filters;


use Illuminate\Contracts\Database\Query\Builder;

interface FilterContract
{
    public function handle(array $filters, Builder $query): Builder;
}
