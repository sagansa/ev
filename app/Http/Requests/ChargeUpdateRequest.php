<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ChargeUpdateRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'battery_start_charging' => ['required', 'numeric'],
            'battery_finish_charging' => ['nullable', 'numeric'],
            'battery_finish_before' => ['required', 'numeric'],
            'km_now' => ['required', 'numeric'],
            'km_before' => ['required', 'numeric'],
            'parking' => ['nullable', 'numeric'],
            'kWh' => ['nullable', 'numeric'],
            'PPJ' => ['nullable', 'numeric'],
            'PPN' => ['nullable', 'numeric'],
            'admin_cost' => ['nullable', 'numeric'],
            'total_cost' => ['nullable', 'numeric'],
            'charger_location_id' => [
                'required',
                'exists:charger_locations,id',
            ],
            'charger_id' => ['required', 'exists:chargers,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
