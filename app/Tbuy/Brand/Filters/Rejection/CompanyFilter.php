<?php

namespace App\Tbuy\Brand\Filters\Rejection;

use App\Enums\MorphType;
use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class CompanyFilter extends Filter implements FilterContract
{

    public function handle(array $filters, Builder $query): Builder
    {
        /** @var EloquentBuilder $query */
        if ($this->isBrand($filters) && isset($filters['company'])) {
            $query->whereHasMorph('rejectionable', MorphType::BRAND->value,
                fn(EloquentBuilder $builder) => $builder->where('brands.company_id', $filters['company'])
            );
        }

        return $query;
    }

    private function isBrand(array $filters): bool
    {
        return isset($filters['type']) && $filters['type'] === MorphType::BRAND->value;
    }

}
