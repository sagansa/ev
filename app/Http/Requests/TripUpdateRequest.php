<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripUpdateRequest extends FormRequest
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
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'user_id' => ['required', 'exists:users,id'],
            'from' => ['required', 'max:255', 'string'],
            'coordinate_from' => ['required', 'max:255', 'string'],
            'to' => ['required', 'max:255', 'string'],
            'coordinate_to' => ['required', 'max:255', 'string'],
        ];
    }
}
