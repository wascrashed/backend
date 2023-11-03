<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Ratingable Interface
 *
 * Этот интерфейс определяет методы, которые должны быть реализованы в классах,
 * которые хотят быть рейтингуемыми.
 */
interface SearchRatingableContract
{
    /**
     * Получить все рейтинги для этого рейтингуемого объекта.
     *
     * @return MorphOne
     */
    public function searchRating(): MorphOne;

    /**
     * Посчитать поисковый рейтинг для модели
     *
     * @return float|int
     */
    public function calculateSearchRating(): float|int;
}
