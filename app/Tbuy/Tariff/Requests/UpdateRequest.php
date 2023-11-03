<?php

namespace App\Tbuy\Tariff\Requests;

use App\Tbuy\Tariff\DTOs\PriceDTO;
use App\Tbuy\Tariff\DTOs\TariffDTO;
use App\Tbuy\Tariff\DTOs\TariffPrivilegeDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'array',
            'name.ru' => ['required', 'string', 'max:100'],
            'name.en' => ['required', 'string', 'max:100'],
            'name.hy' => ['required', 'string', 'max:100'],
            'description' => ['array'],
            'description.ru' => ['required', 'string', 'max:1000'],
            'description.en' => ['required', 'string', 'max:1000'],
            'description.hy' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'array'],
            'price.*' => ['required', 'array'],
            'price.*.price' => ['required', 'numeric'],
            'price.*.discount_price' => ['nullable', 'numeric'],
            'price.*.months' => ['required', 'int'],
            'score' => ['required', 'int'],
            'percent' => ['required', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'privileges' => 'required|array',
            'privileges.*' => 'required|array',
            'privileges.*.name' => 'required|array',
            'privileges.*.name.ru' => 'required|string|max:100',
            'privileges.*.name.en' => 'required|string|max:100',
            'privileges.*.name.hy' => 'required|string|max:100'
        ];
    }

    public function toDto(): TariffDTO
    {
        $payload = $this->validated();
        $payload['price'] = $this->setPrice($payload['price']);
        $payload['privileges'] = $this->setPrivileges($payload['privileges']);

        return new TariffDTO(...$payload);
    }

    private function setPrice(array $priceList): Collection
    {
        return collect(
            array_map(
                fn(array $price) => new PriceDTO(...$price),
                $priceList
            )
        );
    }

    private function setPrivileges(array $privileges): Collection
    {
        return collect(
            array_map(
                fn(array $privilege) => new TariffPrivilegeDTO($privilege['name']),
                $privileges
            )
        );
    }
}
