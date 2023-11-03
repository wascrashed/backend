<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int;
}
