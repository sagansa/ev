<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ChargerLocationUpdateRequest extends FormRequest
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
            'image' => ['image', 'max:1024', 'nullable'],
            'name' => ['required', 'max:100', 'string'],
            'provider_id' => ['required', 'exists:providers,id'],
            'location_on' => ['required', 'in:closed,dealer,private,public'],
            'system' => ['required', 'in:free,hour_base,kwh_base,parking_base'],
            'parking' => ['required', 'in:yes,no'],
            'coordinate' => ['nullable', 'max:100', 'string'],
            'maps' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'in:verified,not verified'],
            'description' => ['nullable', 'max:255', 'string'],
            'province_id' => ['required', 'exists:provinces,id'],
            'city_id' => ['required', 'exists:cities,id'],
        ];
    }
}
