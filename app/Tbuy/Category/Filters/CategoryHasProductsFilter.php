<?php


namespace App\Tbuy\Category\Filters;

use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;

class CategoryHasProductsFilter implements FilterContract
{
    public function handle(array $filters, Builder $query): Builder
    {
        if (isset($filters['has_products']) && $filters['has_products']) {
            $query->whereHas('products', function ($subQuery) {
                $subQuery->where('active', '=', true);
            });
        }

        return $query;
    }
}
