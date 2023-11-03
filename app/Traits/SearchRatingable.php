<?php

namespace App\Traits;

use App\Contracts\SearchRatingableContract;
use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\SearchRatings\Model\SearchRating;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * SearcheRatingable Trait
 *
 * Этот трейт предоставляет методы для работы с рейтингами моделей.
 */
trait SearchRatingable
{
    /**
     * Получить все рейтинги для этой рейтингуемой модели.
     *
     * @return MorphOne
     */
    public function searchRating(): MorphOne
    {
        return $this->morphOne(SearchRating::class, 'ratingable');
    }

    public function calculateSearchRating(): float|int
    {
        $sum = 0;

        if (property_exists($this, 'searchRatingCalculations') && count($this->searchRatingCalculations)) {
            foreach ($this->searchRatingCalculations as $calculation) {
                /**
                 * @var SearchRatingCalculationContract $calculation
                 */
                $sum += (new $calculation())->calculate($this);
            }

            $sum /= count($this->searchRatingCalculations);
        }

        return $sum;
    }

    /**
     * Вычислить средний рейтинг для этой рейтингуемой модели.
     *
     * @return float|null
     */
    public function averageRating(): Builder
    {
        return $this->searchRatings()->avg('rating');
    }
}
