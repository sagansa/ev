<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubMerkVehicleStoreRequest extends FormRequest
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
            'merk_vehicle_id' => ['required', 'exists:merk_vehicles,id'],
            'sub_merk' => [
                'required',
                'unique:sub_merk_vehicles,sub_merk',
                'max:30',
                'string',
            ],
            'battery_capacity' => ['required', 'numeric'],
            'charger_type_id' => ['required', 'exists:charger_types,id'],
        ];
    }
}
