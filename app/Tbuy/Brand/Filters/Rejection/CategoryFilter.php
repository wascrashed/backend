<?php

namespace App\Tbuy\Brand\Filters\Rejection;

use App\Enums\MorphType;
use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class CategoryFilter extends Filter implements FilterContract
{

    public function handle(array $filters, Builder $query): Builder
    {
        /** @var EloquentBuilder $query */
        if ($this->isBrand($filters) && isset($filters['category_id'])) {
            $query->whereHasMorph('rejectionable', MorphType::BRAND->value, function (Builder $builder) use ($filters) {
                /** @var EloquentBuilder $builder */
                $builder->whereHas('categories', function (EloquentBuilder $builder) use ($filters) {
                    $builder->where('category_id', '=', $filters['category_id']);
                });
            });
        }

        return $query;
    }

    private function isBrand(array $filters): bool
    {
        return isset($filters['type']) && $filters['type'] === MorphType::BRAND->value;
    }
}
