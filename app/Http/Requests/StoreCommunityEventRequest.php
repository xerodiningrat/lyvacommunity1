<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreCommunityEventRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', Rule::unique('community_events', 'slug')],
            'icon' => ['required', 'string', 'max:16'],
            'event_date' => ['required', 'date'],
            'status' => ['required', 'string', Rule::in(['live', 'soon', 'finished'])],
            'description' => ['required', 'string'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug((string) $this->input('slug', $this->input('name'))),
            'status' => Str::lower((string) $this->input('status')),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
