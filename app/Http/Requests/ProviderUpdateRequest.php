<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProviderUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('providers', 'name')->ignore($this->provider),
                'max:20',
                'string',
            ],
            'status' => ['required', 'in:inactive,active,not verified'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
