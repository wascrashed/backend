<?php

namespace App\Tbuy\Menu\Requests;

use App\Tbuy\Menu\DTOs\MenuDTO;
use App\Tbuy\Menu\Models\Menu;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        /** @var Menu $menu */
        $menu = $this->route('menu');

        return [
            'name' => 'required|string|max:100',
            'slug' => ['required', 'string', 'max:100', Rule::unique('menus', 'slug')->ignore($menu->id)],
            'menu_id' => ['nullable', 'integer', Rule::exists('menus', 'id')],
            'image' => 'nullable|file|image|mimes:jpg,jpeg,png|max:' . (1024 * 5)
        ];
    }

    public function toDto(): MenuDTO
    {
        return new MenuDTO(...$this->validated());
    }
}
