<?php

namespace App\Tbuy\Company\Requests;

use App\Tbuy\Company\DTOs\CompanyClientDTO;
use App\Tbuy\Company\DTOs\DirectorDTO;
use App\Tbuy\Company\DTOs\PhonesDTO;
use App\Tbuy\Company\DTOs\SocialsDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'array|size:3',
            'name.ru' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'name.hy' => 'required|string|max:100',
            'legal_name_company' => 'required|string|max:100',
            'description' => 'array|size:3',
            'description.ru' => 'nullable|string|max:1000',
            'description.en' => 'nullable|string|max:1000',
            'description.hy' => 'nullable|string|max:1000',
            'company_address' => 'required|string|max:200',
            'logo' => 'nullable|file|image|mimes:jpg,jpeg,png|max:' . (1024 * 10),
            'email' => 'required|email|max:50',
            'director' => 'array',
            'director.first_name' => 'required|string|max:100',
            'director.last_name' => 'required|string|max:100',
            'phones' => 'array|max:7',
            'phones.phone_director' => 'required|string|max:20',
            'phones.phone_sales_department' => 'nullable|string|max:20',
            'phones.phone_marketing_department' => 'nullable|string|max:20',
            'phones.phone_operator' => 'nullable|string|max:20',
            'phones.phone_viber' => 'nullable|string|max:20',
            'phones.phone_whatsapp' => 'nullable|string|max:20',
            'phones.phone_telegram' => 'nullable|string|max:20',
            'socials' => 'array|max:6',
            'socials.website' => 'nullable|string|url|max:200',
            'socials.facebook' => 'nullable|string|url|max:200',
            'socials.instagram' => 'nullable|string|url|max:200',
            'socials.youtube' => 'nullable|string|url|max:200',
            'socials.tiktok' => 'nullable|string|url|max:200',
            'socials.telegram' => 'nullable|string|url|max:200',
        ];
    }

    public function toDto(): CompanyClientDTO
    {
        $socialsDTO = new SocialsDTO(...$this->get('socials', []));
        $phonesDTO = new PhonesDTO(...$this->get('phones', []));
        $directorDTO = new DirectorDTO(...$this->get('director'));

        return new CompanyClientDTO(
            name: $this->get('name', []),
            description: $this->get('description', []),
            email: $this->get('email'),
            director: $directorDTO,
            phones: $phonesDTO,
            socials: $socialsDTO,
            logo: $this->file('logo')
        );
    }
}
