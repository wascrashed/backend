<?php

namespace App\Tbuy\Tariff\Requests;

use App\Tbuy\Tariff\DTOs\TariffBuyDTO;
use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\Tariff\Rules\TariffBuyMonthsRule;
use Illuminate\Foundation\Http\FormRequest;

class BuyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Tariff $tariff */
        $tariff = $this->route('tariff');

        return [
            'term_month' => ['required', 'int', new TariffBuyMonthsRule($tariff)]
        ];
    }

    public function toDto(): TariffBuyDTO
    {
        return new TariffBuyDTO(...$this->validated());
    }
}
