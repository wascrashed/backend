<?php

namespace App\Tbuy\Company\Filters;

use App\Enums\MorphType;
use App\Tbuy\Filters\Filter;
use App\Tbuy\Filters\FilterContract;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class RelationsRejectedFilter extends Filter implements FilterContract
{
    public function handle(array $filters, Builder $query): Builder
    {
        $query->when($this->isCompany($filters),
            fn(EloquentBuilder $builder) => $builder->with([
                'rejectionable.brandDocument',
                'rejectionable.innDocument',
                'rejectionable.passportDocument',
                'rejectionable.stateRegisterDocument',
            ])
        );

        return $query;
    }

    private function isCompany(array $filters): bool
    {
        return isset($filters['type']) && $filters['type'] === MorphType::COMPANY->value;
    }
}
