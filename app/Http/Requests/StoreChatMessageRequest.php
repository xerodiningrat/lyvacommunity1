<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChatMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, \Illuminate\Contracts\Validation\ValidationRule|string>|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:500'],
            'reply_name' => ['nullable', 'string', 'max:255'],
            'reply_text' => ['nullable', 'string', 'max:500'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'message' => trim((string) $this->input('message')),
            'reply_name' => filled($this->input('reply_name')) ? trim((string) $this->input('reply_name')) : null,
            'reply_text' => filled($this->input('reply_text')) ? trim((string) $this->input('reply_text')) : null,
        ]);
    }
}
