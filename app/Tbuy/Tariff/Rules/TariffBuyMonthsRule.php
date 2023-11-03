<?php

namespace App\Tbuy\Tariff\Rules;

use App\Tbuy\Tariff\Models\Tariff;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class TariffBuyMonthsRule implements ValidationRule
{
    public function __construct(
        private readonly Tariff $tariff
    )
    {
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->tariff->price->where('months', $value)->count() <= 0) {
            $fail('Тариф с указанным количеством месяца не существует');
        }
    }
}
