<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends FormRequest
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
            'license_plate' => ['required', 'max:10', 'string'],
            'ownership' => ['required', 'date'],
            'type_vehicle_id' => ['required', 'exists:type_vehicles,id'],
            'user_id' => ['required', 'exists:users,id'],
            'merk_vehicle_id' => ['required', 'exists:merk_vehicles,id'],
            'sub_merk_vehicle_id' => [
                'required',
                'exists:sub_merk_vehicles,id',
            ],
        ];
    }
}
