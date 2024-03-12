<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MerkVehicleUpdateRequest extends FormRequest
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
            'type_vehicle_id' => ['required', 'exists:type_vehicles,id'],
            'merk' => [
                'required',
                Rule::unique('merk_vehicles', 'merk')->ignore(
                    $this->merkVehicle
                ),
                'max:20',
                'string',
            ],
        ];
    }
}
