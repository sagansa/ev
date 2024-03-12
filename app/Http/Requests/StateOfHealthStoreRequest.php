<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StateOfHealthStoreRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'max:1024'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'km' => ['required', 'numeric'],
            'percentage' => ['required', 'numeric'],
            'how_to_charge' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'in:not verified,verified'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
