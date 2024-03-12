<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProviderStoreRequest extends FormRequest
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
            'name' => ['required', 'unique:providers,name', 'max:20', 'string'],
            'status' => ['required', 'in:inactive,active,not verified'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
