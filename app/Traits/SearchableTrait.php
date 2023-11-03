<?php

namespace App\Traits;

use App\Tbuy\Search\Model\SearchableField;
use Illuminate\Contracts\Database\Query\Builder;
use Laravel\Scout\Searchable;

trait SearchableTrait
{
    use Searchable;

    public function toSearchableArray(): array
    {
        $output = [];

        $fields = SearchableField::query()->with([
            'searchableModel.modelList',
            'modelField'
        ])->whereHas('searchableModel.modelList', fn(Builder $q) => $q->where('model', self::class))
            ->orderBy('priority', 'DESC')->get();

        foreach ($fields as $field) {
            $output[$field->modelField->slug] = $this->{$field->modelField?->slug};
        }

        return $output;
    }

    public function searchableAs(): string
    {
        return config('scout.searchableAs');
    }
}
