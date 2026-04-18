<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreShopItemRequest extends FormRequest
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
     * @return array<string, array<int, \Illuminate\Contracts\Validation\ValidationRule|string>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('shop_items', 'slug')],
            'emoji' => ['required', 'string', 'max:16'],
            'badge_label' => ['nullable', 'string', Rule::in(['HOT', 'RARE', 'NEW', 'VIP'])],
            'price' => ['required', 'integer', 'min:0'],
            'currency' => ['required', 'string', 'max:24'],
            'stars' => ['required', 'integer', 'between:0,5'],
            'gradient_from' => ['required', 'string', 'max:16'],
            'gradient_to' => ['required', 'string', 'max:16'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug((string) $this->input('slug', $this->input('name'))),
            'badge_label' => filled($this->input('badge_label')) ? Str::upper((string) $this->input('badge_label')) : null,
            'currency' => $this->input('currency', 'Robux'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
